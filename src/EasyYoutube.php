<?php

class EasyYoutube
{

    private $connected = false;
    private $client = false;
    private $key = false;
    private $secret = false;

    public function __construct($key, $secret){
        $this->key  = $key;
        $this->secret = $secret;
    }

    private function connect()
    {
        $client = new Google_Client();
        $client->setClientId($this->key);
        $client->setClientSecret($this->secret);
        $client->setScopes('https://www.googleapis.com/auth/youtube.readonly');
        $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);
        $client->setRedirectUri($redirect);


        if (isset($_GET['code'])) {
            if (strval($_SESSION['state']) !== strval($_GET['state'])) {
                die('The session state did not match.');
            }

            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            header('Location: ' . $redirect);
        }

        if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
        }

        $this->client = $client;
    }

    public function getUserChannel()
    {
        $this->connect();
        $client = $this->client;


        // Define an object that will be used to make all API requests.
        $youtube = new Google_Service_YouTube($client);


        // Check to ensure that the access token was successfully acquired.
        if (!$client->getAccessToken()) {
            return false;
        }

        try {

            // Call the API's channels.list method with mine parameter to fetch authorized user's channel.
            $listResponse = $youtube->channels->listChannels(
                'snippet',
                array(
                    'mine' => 'true',
                )
            );

            /** @var Google_Service_YouTube_Channel $responseChannel */
            $responseChannel = $listResponse[0];

            $id = $responseChannel->getId();

            /** @var Google_Service_YouTube_ChannelSnippet $snippet */
            $snippet = $responseChannel->getSnippet();

            /** @var Google_Service_YouTube_ThumbnailDetails $thumbs */
            $thumbs = $snippet->getThumbnails();
            $image  = $thumbs->getDefault();


        } catch (Google_ServiceException $e) {
            echo sprintf(
                '<p>A service error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage())
            );
            return false;
        } catch (Google_Exception $e) {
            echo sprintf(
                '<p>An client error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage())
            );
            return false;
        }

        $_SESSION['token'] = $client->getAccessToken();

        return array(
            "id"          => $id,
            "title"       => $snippet->title,
            "description" => $snippet->description,
            "image"       => $image,
        );
    }

    public function getAuthUrl(){
        // If the user hasn't authorized the app, initiate the OAuth flow
        $state = mt_rand();
        $this->client->setState($state);
        $_SESSION['state'] = $state;

        return $this->client->createAuthUrl();
    }

    public function findUser($channelId, $log = true){
        $result = ORM::forTable('addresses')->where('youtube_id', $channelId)->findOne();

        if($result !== false){
            $result->requests = $result->requests + 1;
            $result->updated = sqlStamp();
            $result->save();
        }

        return $result;
    }

    public function search($query = false){
        if(empty($query)){
            $query = '';
        }
        $result = ORM::for_table('addresses')->where_like('name', '%'.$query.'%')->order_by_desc("requests")->find_many();

        return $result;
    }
}