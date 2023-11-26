<!DOCTYPE html>
<html>
<body>

<h1 style="text-align:center; padding-top: 100px">Admin Page</h1>

<?php
    session_start();

    //check if session is logged as admin
    if( !isset($_SESSION['isLoggedIn']) && !isset($_SESSION['isAdmin']) ) {
        header("Location: index.php");
        die( "Login required.");
    }
?>

<?php 
  //connect to database
  require_once 'config.php';
  $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if ($mysqli->connection_error) { die("Connection failed: " . $mysqli->connect_error); }

//COMMENTS

  //View All Comments
  if(isset($_POST['comments'])){
    $sql = "SELECT * FROM form";
      if ($showing = $conn->query($sql)){

        while ($row = $showing->fetch_assoc()) {
          $col1 =$row["form_id"];
          $col2 = $row["comment"];
          $col3 = $row["user_id"];

          echo "ID: " . $col1 . 
          "  ,  Comment: " . $col2 . 
          " , UID: " . $col3 .
          "<br>";
        }
      }
  }

//Delete Comments
if(isset($_POST['deletecom'])) {
  $did = $_POST['id'];

  $sql = "DELETE FROM form WHERE form_id = '$did'";
  $sql_ifexist = "SELECT form_id FROM form WHERE form_id = '$did'";
  $num = $conn->query($sql_ifexist);

  if($num->num_rows == 0){
    echo "Record Does Not Exist";
  }
  else {
    if($result=$conn->query($sql)){
      echo "Record Number: " . $did . " Deleted";
    }
    else {
      echo "Error in Deleting";
    }
  }
}

//USERS

  //View All Users
  if(isset($_POST['view'])){
    $sql = "SELECT * FROM users";
      if ($showing = $conn->query($sql)){

        while ($row = $showing->fetch_assoc()) {
          $col1 =$row["id"];
          $col2 = $row["user_id"];

          echo "ID: " . $col1 . 
          "  ,  UID: " . $col2 . "<br>";
        }
      }
  }

  //Create New User
  if(isset($_POST['create'])){
    $userid = $_POST['user'];
    $pwd = $_POST['password'];

    $sqlcheck = "SELECT user_id FROM users WHERE user_id = '$userid'";
    $sql = "INSERT INTO users (user_id, pwd) VALUES ('$userid','$pwd')";
    $results = $conn->query($sqlcheck);

    if($results->num_rows > 0){
      echo "User Exists";
    } 
    else { 
      $result = $conn->query($sql);
      echo "User " . $userid . " Added";
    }
  }

  //Delete Users
  if(isset($_POST['delete'])) {
    $did = $_POST['id'];
    if ($did == 1){
      echo "Not Allowed to delete Admin - ";
      $did = "";
    }

    $sql = "DELETE FROM users WHERE id = '$did'";
    $sql_ifexist = "SELECT id FROM users WHERE id = '$did'";
    $num = $conn->query($sql_ifexist);

    if($result->num_rows == 0){
      echo "Record Does Not Exist";
    }
    else {
      if($result=$conn->query($sql)){
        echo "Record Number: " . $did . " Deleted";
      }
      else {
        echo "Error in Deleting";
      }
    }
  }

  if(isset($_POST['back'])){
    header('Location: welcome.php');
  }
?>

<form style="text-align:center; padding:30px;" action="admin.php" method= "post"s>
  <input name='view' type='submit' value='View All Users'/>
  <input name='comments' type='submit' value='View All Comments'/>
  <br></br>
</form>

<form style="text-align:center; padding:30px;" action="admin.php" method= "post"s>
  <label for="id">ID:</label>
  <input id="id" name="id" required="" type="number" />
  <input name='delete' type='submit' value='Delete User'/>
  <input name='deletecom' type='submit' value='Delete Comment'/>  
</form>

<form style="text-align:center; padding:30px;" action="admin.php" method= "post">
  <!-- input for username -->
  <label for="user">Username:</label>
  <input id="user" name="user" required="" type="text" />
  <!-- input for password -->
  <label for="password">Password:</label> 
  <input id="password" name="password" required="" type="password" />
  <!-- create user -->
  <input name='create' type='submit' value="Create"/>
</form>

<form style="text-align:center; padding:30px;" action="admin.php" method= "post">
  <input name='back' type='submit' value='Back'/>
</form>

</body>
</html>