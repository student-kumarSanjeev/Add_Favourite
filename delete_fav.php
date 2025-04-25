<?php
include('connection.php');  

$id = $_GET['id'];
echo $id;
$sql = "DELETE FROM `user_api_table` WHERE `user_api_table`.`fav_id` = $id";
$result = mysqli_query($conn, $sql);
if($result){
    echo "Record deleted";
    header("Location:./fav_api.php");
}
?>