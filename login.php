<!-- $sql = "SELECT * FROM `users` WHERE `email` = '$email'"; -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('connection.php');

$emailVal = "";
$passwordVal = "";
$login_error = "";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result,MYSQLI_ASSOC); 
   
    $emailVal = isset($_POST['email']) ? $_POST['email']:"";
    $passwordVal = isset($_POST['password']) ? $_POST['password']:"";

    if($user){  
      session_start();
      $_SESSION['user']=$user;
      header('Location:./fav_api.php');
    }else{
      $login_error = "<div class='text-red-700 font-semibold'>!Error, Check your email and password</div>";
    }
}
?>

<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body>
  <div class="container mx-auto mt-[100px] flex h-[65vh] w-[25vw] flex-col items-center justify-center gap-[20px] rounded-[20px] bg-gray-100 shadow-2xl">
    <h1 class="text-[30px] font-bold text-orange-500">Sign In</h1>
    <?php echo $login_error;?>
    <form action="" method="POST"> 
      <label for="email" class='text-[20px] text-gray-800 font-semibold'>Email:</label><br /><br>
      <input autocomplete="off" type="email" name="email" value="<?php echo $emailVal;?>" id="email" placeholder="Enter email" class="w-[350px] rounded-[10px] border p-[13px]" /><br /><br />
     
      <label for="password" class='text-[20px] text-gray-800 font-semibold'>Password:</label><br /><br>
      <input type="password" name="password" value="<?php echo $passwordVal;?>" id="password" placeholder="Enter password" class="w-[350px] rounded-[10px] border p-[13px]" /><br /><br />
     
      <input type="submit" name="login" value="Sign In" class="h-[55px] text-[18px] font-semibold w-[350px] cursor-pointer rounded-2xl bg-orange-400 p-[13px] transition-all hover:bg-orange-300" />
      <br><br>
    </form>
  </div>
  </body>
</html>