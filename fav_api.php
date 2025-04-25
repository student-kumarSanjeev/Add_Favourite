<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('connection.php');

session_start();
if(!$_SESSION['user']){
  header("Location:./login.php");
}
$user_id = $_SESSION['user']['id'];

$id = isset($_GET['id'])?$_GET['id']:null;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://jsonplaceholder.typicode.com/users");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
$response = json_decode($res,true);
curl_close($ch);

// Insert query.
if($id){
  $sql2= "INSERT INTO `user_api_table` (`fav_id`,`user_id`) VALUES ('$id', '$user_id')";
  $result2 = mysqli_query($conn, $sql2);
}
$sql = "SELECT fav_id FROM `user_api_table` WHERE `user_id` = $user_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_num_rows($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>curl Fev API</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <?php
    $row = mysqli_fetch_all($result);
    ?>
        <h1 class="flex items-center justify-around text-[25px] font-bold mt-[20px]">Users Data</h1>
    <center class="flex items-center justify-around m-[10px]">
        <a href="./added_items.php" class="text-[23px] text-white bg-red-400 p-[10px] rounded-[25px] p-[10px] hover:bg-red-600 transition-all font-bold  mt-[20px]">Favorite Items</a>
        <a href="./logout.php" class="text-[23px] text-white bg-red-400 p-[10px] rounded-[25px] hover:bg-red-600 transition-all font-bold mt-[20px]">Logout</a>
    </center>
  <div class="grid grid-cols-5">
  <?php
      
    foreach($response as $data){
      ?>  
        <div class=" m-[20px]  max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $data['id'].". ".$data['name'];?></h5>
          <p class="mb-2 text-[18px] font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $data['email'];?></p>
          <p class="mb-2 text-[18px] font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $data['phone'];?></p>
          <p class="mb-2 text-[18px] font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $data['website'];?></p>
          <?php
          $re = array_column($row,0);

          if(!in_array($data['id'],$re)){
            ?>
              <a href="./fav_api.php?id=<?php echo $data['id']?>">
              <i class="fa-solid fa-heart fa-xl ml-[250px]" style="color:rgb(186, 159, 161);" ></i></a>
                          
            <?php
          }else{
            ?>
              <a href="./delete_fav.php?id=<?php echo $data['id']?>"><i class="fa-solid fa-heart fa-xl flex ml-[250px]" style="color: #f0192e;"></i></a>
            <?php
          }
          ?>
          </div>
        <?php
    }
  ?>
  </div>
</body>
</html>