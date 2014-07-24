

<?php if($authUrl !== false): ?>
<div class="row">
    <div class="large-12 columns" role="content">

        <h4 class="center">
            Ready to start getting tips for your awesome you tube videos?
        </h4>


        <a class="center radius button" href="<?php echo $authUrl ?>">
            Connect My Youtube Channel
        </a>
    </div>
</div>
<?php else: ?>
    <div class="row">
        <div class="large-6 columns" role="content">

            <h4 class="center">
                You're connected.
            </h4>

            <p>
                Now just enter your tip address and start receiving reddcoin.
            </p>

        </div>

        <div class="large-6 columns" role="content">
            <img src="<?php echo $channel["image"]->url ?>" style="float:left; margin-right:20px;">
            <div>
                <h4 style="">
                    <a href="https://www.youtube.com/channel/<?php echo $channel["id"] ?>" target="_blank">
                        <?php echo $channel["title"]; ?>
                    </a>
                </h4>
                <p class="small">
                    <?php echo $channel["description"]; ?>
                </p>
            </div>

            <div style="clear:both">
                <form method="post">

                    <input type="text" placeholder="RDD Address" name="address" value="<?php if($addressRow) { o($addressRow->address); } ?>">

                    <input type="submit" value="Update Address" class="radius button">

                </form>

            </div>

        </div>
    </div>
<?php endif; ?>
