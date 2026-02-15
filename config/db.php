
<?php 
$servername = "localhost";
$username = "root";
$password = "sarun@sql789";
$dbName = "job_portal";

//create connnection
$conn = new mysqli($servername, $username, $password, $dbName);

//check connection
if($conn->connect_error){
    die("Databse Connection Failed: ".$conn->connect_errno);
}
?>