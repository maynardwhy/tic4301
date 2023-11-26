<!DOCTYPE html>
<html>
<body>

<h1 style="text-align:center; padding-top: 100px">Wedding Page</h1>
<h3 style="text-align:center;">Welcome to the Wedding of ABC & XYZ</h3>
<p style="text-align:center;">Login to leave a comment for the couple!</p>

<?php 
//connect to database
  require_once 'config.php';
  $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if ($mysqli->connection_error) { die("Connection failed: " . $mysqli->connect_error); }

  //define user input
  $user = $_POST['user'];
  $password = $_POST['password'];

  if(isset($_POST['login'])) {

    $sqlcheck = "SELECT user_id FROM users WHERE user_id = '$user'";
    $sqlget = "SELECT user_id, pwd FROM users WHERE user_id ='$user' && pwd='$password'";
    $result = $conn->query($sqlcheck);

    if($result->num_rows == 0){
      echo "User No Exist";
    }
    else {
      $result = $conn->query($sqlget);
      if($result->num_rows==0){
        echo "Wrong Password";
      }
      else {
        session_start();
        $_SESSION['isLoggedIn'] = true;
        if($user == "admin"){
          $_SESSION['isAdmin'] = true;
        }
        $_SESSION['uid'] = $user;

        header("Location: welcome.php");
      }
    }
  }

?>
<form style="text-align:center; padding:30px;" action="index.php" method="post">
  <!-- input for username -->
  <label for="user">Username:</label>
  <input id="user" name="user" required="" type="text" />
  <!-- input for password -->
  <label for="password">Password:</label> 
  <input id="password" name="password" required="" type="password" />
  <!-- submit button -->
  <input name="login" type="submit" value="Login" />
</form>

</body>
</html>