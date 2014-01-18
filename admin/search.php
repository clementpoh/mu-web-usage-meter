
<?php
    require_once("../settings.php");
    require_once("../lib/proxylib.php");

    if (isset($_GET['username'])) {

        # Print the usage table for this username.
        display_usage($_GET['username'], 'sit_display');

    } else {
        echo '<p class="notice">Please input a username into the URL.</p>';
    }
?>


