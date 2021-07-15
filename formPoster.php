<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$bucket = $_ENV['BUCKET'];
$bucket_pw = $_ENV['BUCKET_PW'];

$link = mysqli_connect("localhost", $bucket, $bucket_pw, "chiefweb_emailTickets");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Escape user inputs for security
$first_name = mysqli_real_escape_string($link, $_REQUEST['name']);
$email = mysqli_real_escape_string($link, $_REQUEST['email']);
$msg = mysqli_real_escape_string($link, $_REQUEST['message']);
 
// Attempt insert query execution
$sql = "INSERT INTO emails (first_name, email, msg) VALUES ('$first_name', '$email', '$msg')";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>