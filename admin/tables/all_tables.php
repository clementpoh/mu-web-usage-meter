<?php
	echo("<h1>Attempting to connect to sawyer</h1>\n");
	$ora_db_host = 'sawyer.its.unimelb.edu.au';
	$ora_db_sid = 'PRXD';
	$ora_db_location = "(DESCRIPTION =
	 (ADDRESS = (PROTOCOL = TCP)(HOST = $ora_db_host)(PORT = 1521))
	 (CONNECT_DATA = (SID = $ora_db_sid)))";

    # Connect to DB
    $conn = oci_connect('ssuser', 'J90fds&s', '//sawyer.its.unimelb.edu.au/PRXD');
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    
	$stid = oci_parse($conn, "SELECT * FROM all_all_tables WHERE tablespace_name = 'USERS'");
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
