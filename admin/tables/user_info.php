<?php
    # Connect to DB
    $conn = oci_connect('ssuser', 'J90fds&s', '//sawyer.its.unimelb.edu.au/PRXD');
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    
	$stid = oci_parse($conn, "SELECT * FROM (SELECT * FROM user_info) WHERE ROWNUM <= 1000");
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
