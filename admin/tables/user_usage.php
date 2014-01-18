<?php
    # Connect to DB
    $conn = oci_connect('ssuser', 'J90fds&s', '//sawyer.its.unimelb.edu.au/PRXD');
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $monday = strtoupper(strftime("'%d-%b-%y'", strtotime('last monday')));
	$stid = oci_parse($conn, "SELECT * FROM (SELECT * FROM user_usage ORDER BY usage_date DESC) WHERE usage_date >= " . $monday);
	oci_execute($stid);

	echo "<table>";
	while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
		echo "<tr>\n";
		foreach ($row as $key => $item) {
			echo "<th>" . $key . "</th>";
			echo "<td>" . $item . "</td>";
		}
		echo "</tr>\n";
	}
	echo "</table>";

	oci_close($conn);
?>
