<?php
    require_once('settings.php');
    date_default_timezone_set('Australia/Melbourne');

    # Authenticate the username and password, in the $_POST data.
    function session_authenticate() {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            if(authenticate($ldap_conn, $_POST["username"], $_POST["password"])) {
                header('Location: index.php');
                exit;
            } else {
                header("Location: auth.php?auth_err=" . $_POST['username']);
                exit;
            }
        } else if (isset($_GET['logout'])) {
            session_destroy();
            header('Location: auth.php');
            exit;
        } else if (isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }

    }

    # Retrieves the personal information related to $username since $monday.
    function retrieve_user_info($conn, $username, $monday) {
        $stid = oci_parse($conn, "SELECT effective_to FROM user_lock WHERE user_name = '$username' AND effective_from >= '$monday'");
        oci_execute($stid);

		while($row = oci_fetch_array($stid, OCI_NUM)) {
			$info['locked'] = strftime('%d %B %Y', strtotime($row[0]));
		}
        
        $stid = oci_parse($conn, "SELECT full_name, user_type FROM user_info WHERE user_name = '$username'");
        oci_execute($stid);

		while($row = oci_fetch_array($stid, OCI_NUM)) {
			$info['name'] = $row[0];
            $info['type'] = (strstr($row[1], 'staff')) ? 'Staff' : 'Student';

		}

        return (isset($info) ? $info : NULL);

    }

    function orig_display_user_info($username, $info) {
        if(isset($info['name'])) {
            echo "<h2>".$info['name']."</h2><p>".$info['type']."</p>";
            if(isset($info['locked'])) {
                echo "<p id='error'>Quota Exceeded. Locked until ". $info['locked'] .".</p>";
            } else {
                echo "<p>Active</p>";
            }
        } else {
            echo "<p id='error'>Error: '$username' could not be found</p>";
        }
    }

    function authenticate($ldap_conn, $username, $password) {
        $ldap_conn = ldap_connect(LDAP_URI) or die("Error: Could not connect to authentication server");

        if (ldap_bind($ldap_conn,"uid=$username,ou=people,o=unimelb", $password)) {
            $_SESSION['username'] = $username;
            return True;
        } else {
            return False;
        }
    }

    function orig_usage_meter($usage) {

        $mb_remaining = (MAX_QUOTA - $usage) / 1000;
        $pc_remaining = (MAX_QUOTA - $usage) / (MAX_QUOTA / 100); 
        echo "<div id='usagemeter'></div>";
        echo "<strong>" . (($mb_remaining > 0) ? number_format($mb_remaining, 2) : '0.00') . " MBs remaining</strong>";
        echo "<script>$('#usagemeter').progressbar({ value : ". $pc_remaining ." });</script>"; 
    }

    function sit_display_user_info($username, $info) {
        if(isset($info['name'])) {
            echo "<h2>".$info['name'].'</h2><p class="lt marginlt">'.$info['type']."</p>";
            if(isset($info['locked'])) {
                echo "<p id='error'>Quota Exceeded. Locked until ". $info['locked'] .".</p>";
            }
        } else {
            echo "<p id='error'>Error: '$username' could not be found</p>";
        }
    }

	function total_usage($conn, $username, $date) {
		$stid = oci_parse($conn, "SELECT SUM(external_usage_kb) FROM user_usage WHERE user_name = '$username' AND usage_date >= '$date'");
		oci_execute($stid);
		$sum = oci_fetch_array($stid, OCI_NUM);

		return isset($sum[0]) ? $sum[0] : NULL;
	}

    function connect_to_sawyer() {
        $conn = oci_connect(ORACLE_USERNAME, ORACLE_PASSWORD, ORACLE_ADDRESS);
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        } else {
            return $conn;
        }
    }

	function display_usage($username, $display_func) {
        $username = strtolower($username);
		$monday = strftime('%d-%b-%y', strtotime('last Monday'));

        # Connect to DB
        $conn = connect_to_sawyer();

        $info = retrieve_user_info($conn, $username, $monday);
		$usage = usage_array($conn, $username, $monday);
        $total = total_usage($conn, $username, $monday);

        $display_func($username, $info, $usage, $total);
        # Disconnect from the oracle DB
        oci_close($conn);
	}


    function orig_display($username, $info, $usage, $total) {
        orig_display_user_info($username, $info);
        orig_usage_meter($total);
        orig_usage_table($total, $usage);
    }

    function sit_display($username, $info, $usage, $total) {
        sit_display_user_info($username, $info);
        sit_usage_meter($total, $info);
        sit_usage_table($total, $usage);
    }


    function sit_usage_meter($usage, $info) {

        $mb_remaining = (MAX_QUOTA - $usage) / 1000;
        $pc_remaining = (MAX_QUOTA - $usage) / (MAX_QUOTA / 100); 
        echo "<div id='usagemeter'></div>";
        echo "<div class='colwrapper'>";
        echo "<div class='two_col lt service_status'>Status: ".(isset($info['locked'])?"Locked":"Active")."</div>";
        echo "<div class='two_col usage_remaining'>" . (($mb_remaining > 0) ? number_format($mb_remaining, 2) : '0.00') . " MBs remaining</div>";
        echo "</div>";
        echo "<script>$('#usagemeter').progressbar({ value : ". $pc_remaining ." });</script>"; 
    }

    function orig_usage_table($total, $usage) {
		$out = "<table>";
		$out .= "<thead><tr><th>Date</th><th>Usage MBs</th></tr></thead>";
		$out .= "<tfoot><tr><th>Weekly Total</th><th>" . number_format($total / 1000, 2) . "</th></tr></tfoot>"; 

		
		for($i = strtotime('last Monday'); $i < strtotime('today'); $i = strtotime('+1 day', $i)) {
			$out .= "<tr>\n";
			$out .= "\t<td>" . strftime('%A %d %b', $i) . "</td><td>" . get_usage($usage, $i) . "</td>\n";
			$out .= "</tr>\n";
		}
		
		$out .= "</table>";

		echo $out;
    }

    function sit_usage_table($total, $usage) {
		$out  = "<table cellspacing='0'>";
		$out .= "<thead><tr><th class='lt table_underline'>Date</th><th class='table_underline'>Usage MBs</th></tr></thead>";
		$out .= "<tfoot><tr><th class='lt'>Weekly Total</th><th>" . number_format($total / 1000, 2) . "</th></tr></tfoot>"; 

		$j = 1;
		for($i = strtotime('last Monday'); $i < strtotime('today'); $i = strtotime('+1 day', $i)) {
			$out .= ($j++ % 2) ? "<tr class='odd'>\n": "<tr>\n";
			$out .= "<td class='lt'>" . strftime('%A %d %b', $i) . "</td><td>" . get_usage($usage, $i) . "</td>\n";
			$out .= "</tr>\n";
		}
		
		$out .= "</table>";

		echo $out;
    }

	function get_usage($usage, $timestamp) {
		$d = strtoupper(strftime('%d-%b-%y', $timestamp));

		if (isset($usage[$d])) {
            # Convert to MBs then format for display.
			return number_format($usage[$d] / 1000, 2);
		} else {
			return "0.00";
		}
	}


    # Returns an array of $username's usage in KBs since $monday.
	function usage_array($conn, $username, $monday) {
		$stid = oci_parse($conn, "SELECT usage_date, external_usage_kb FROM user_usage WHERE user_name = '$username' AND usage_date >= '$monday'");
		oci_execute($stid);

		while($row = oci_fetch_array($stid, OCI_NUM)) {
			$rows[$row[0]] = $row[1];
		}

		return isset($rows) ? $rows : NULL;
	}

    function is_authenticated() {
        if (!isset($_SESSION['username'])) {
            header('Location: auth.php');
            exit;
        }
    }

?>
