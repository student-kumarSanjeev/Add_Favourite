<?php
include('connection.php');

session_start();
if(!$_SESSION['user']){
    header("Location:./login.php");
  }
$user_id = $_SESSION['user']['id'];
// sql query 
$arr = [];
$sql = "SELECT fav_id FROM `user_api_table` WHERE `user_id` = $user_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_all($result);
$arrData = array_column($row,0);

foreach($arrData as $d){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://jsonplaceholder.typicode.com/users/$d");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response,true);
    $arr[] = $data;
    curl_close($ch);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>curl Fev API</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <center>
        <h1 class="text-[26px] font-bold mt-[20px]">Favorite Users</h1>
    </center>
  <div class="flex flex-row flex-wrap gap-[20px]">
    <?php
        foreach($arr as $data){
        ?>
        <div class=" m-[30px] max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 w-[350px]">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $data['id'].". ".$data['name'];?></h5>
            <p class="mb-2 text-[18px] font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $data['email'];?></p>
            <p class="mb-2 text-[18px] font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $data['phone'];?></p>
            <p class="mb-2 text-[18px] font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $data['website'];?></p>
            <a href="./fav_api.php" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-500 transition-all rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Back</a>
        </div><br>
        <?php
        }
    ?>  
  </div>
  <?php echo $fav; ?>

</body>
</html>

