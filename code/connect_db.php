
<?php

    // defines all the needed values to connect to the database
define("SERVERNAME" ,"localhost");
define("DB" ,"projectp4");
define("USERNAME" ,"targa2002260");
define("PASSWORD" ,"9januari");

    // stitches the connection command to connect to the database together 
$this->conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DB);
?>

