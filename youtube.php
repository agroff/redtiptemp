<?php

require_once __DIR__.'/src/init.php';


$channel = $easy->getUserChannel();

$authUrl    = false;
$addressRow = false;
if($channel === false){
    $authUrl = $easy->getAuthUrl();
}
else {

    $addressRow = $easy->findUser($channel["id"]);

    $postedAddress = post("address");

    if($postedAddress){
        if($addressRow === false){

            $addressRow = ORM::for_table('addresses')->create();
            $addressRow->youtube_id = $channel["id"];
            $addressRow->requests = 0;
            $addressRow->address = $postedAddress;
            $addressRow->name = $channel["title"];
            $addressRow->description = $channel["description"];
            $addressRow->updated = sqlStamp();

            $addressRow->save();
        }
        else {
            $addressRow->address = $postedAddress;
            $addressRow->name = $channel["title"];
            $addressRow->description = $channel["description"];
            $addressRow->updated = sqlStamp();

            $addressRow->save();
        }
    }
}

$data = array(
    "channel" => $channel,
    "authUrl" => $authUrl,
    "addressRow" => $addressRow,
);

fullView("home", $data);

?>
