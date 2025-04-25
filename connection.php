<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'user_api';

$conn = mysqli_connect($server, $username, $password, $database);
if(!$conn){
    die("connection was die".mysqli_connect_error());
}
?>