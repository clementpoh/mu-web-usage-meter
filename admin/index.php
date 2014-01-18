<?php
    error_reporting(-1);
    require_once("../lib/proxylib.php");
?>
<!DOCTYPE html>  
<html xmlns="http://www.w3.org/1999/xhtml" lang="en"> 
    <head> 
        <?php require("../content/header.php"); ?>
        <script>
            function lookup(username) {
                if (username != '') {
                    xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange=function() {
                        if (xmlhttp.readyState == 4) {
                            var div = document.getElementById("usage");
                            div.innerHTML = xmlhttp.responseText;
                            scripts = div.getElementsByTagName("script");
                            for(i = 0; i < scripts.length; i++) {
                                eval(scripts[i].text);
                            }
                        }
                    }
                    xmlhttp.open("GET", "search.php?username="+username, true);
                    xmlhttp.send();
                }
            }
        </script>
    </head> 
    <body> 
        <div class="content"> 
            <h1>Web Usage Meter</h1>
            <form onsubmit="return false;">
                <fieldset>
                    <legend>Search</legend>
                    <div class='q'>
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" onchange="lookup(this.value)"> 
                    </div>
                </fieldset>
            </form>
            <div id="usage">Enter a Username</div>
            <p><small>Written and maintained by Clement Poh, Learning Environments</small></p>
        </div>
    </body> 
</html>
