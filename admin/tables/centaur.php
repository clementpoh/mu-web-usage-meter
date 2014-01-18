<?php
    $LDAP_URI = 'ldaps://centaur.unimelb.edu.au/';
    $ldapconn = ldap_connect($LDAP_URI) or die("Error: Could not connect to authentication server");

    if (ldap_bind($ldapconn,"uid=cjpoh,ou=people,o=unimelb", '4K47$uK1')) {
        echo 'Bind Successful!';
    }

    $result = ldap_search($ldapconn, 'uid=cjpoh,ou=people,o=unimelb', "(cn=*)");

    $info = ldap_get_entries($ldapconn, $result);

    echo '<table>';
    foreach ($info[0] as $val) {
        if (is_string($val)) {
            echo "<tr><th>".$val."</th>";
        } else {
            echo "<td>".$val[0]."</td></tr>";
        }
    }
    echo '</table>';

    /* 
    $result = ldap_search($ldapconn, 'uid=cjpoh,ou=people,o=unimelb', "(uid=cjpoh)", array('cn','auedupersontype'));

    $info = ldap_get_entries($ldapconn, $result);

    var_dump($info);

    echo $info[0]['cn'][0];
    echo $info[0]['auedupersontype'][0];
    */
?>
