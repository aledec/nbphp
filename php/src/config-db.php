<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

    $db_servername = "localhost";
    $db_database = "nbu" ;
    $db_username = "nbu_nbphp" ;
    $db_password = "A7AG79EZN8ETdNmN";

//    $log_directory = "../sql";


// Create connection
$conn = new mysqli($db_servername, $db_username, $db_password, $db_database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//foreach (glob("$log_directory/*.sql*") as $filename) {
//    echo "$filename \r\n";
//    $sql = file_POST_contents($filename);
//    echo 'processing file <br />';
//    $conn->query($sql);
//    unlink($filename);
//}
//¡¡ini_set('display_errors', 'On');
//error_reporting(E_ALL);

?>
