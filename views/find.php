<div class="row">
    <div class="large-5 columns" role="content">

        <h4 class="center">
            Find some fancy reddcoin youtubers.
        </h4>

        <form method="post">

            <input type="text" name="query" placeholder="search">

            <input type="submit" value="Search" class="radius button">

        </form>


    </div>

    <div class="large-7 columns" role="content">
        <?php foreach($results as $result): ?>
            <div class="account">
                <span class="find address">
                    <?php
                    $fixed = substr($result["address"], 0,  10) . '[...]' . substr($result["address"], 26);
                    ?>
                    <?php o($fixed); ?>
                </span>
                <h5>
                    <span class="score">
                        [<?php o($result["requests"]); ?>]
                    </span>
                    <a href="https://www.youtube.com/channel/<?php o($result["youtube_id"]) ?>" target="_blank">
                        <?php o($result["name"]); ?>
                    </a>
                </h5>
                <p>
                    <?php o($result["description"]); ?>
                </p>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
</div>