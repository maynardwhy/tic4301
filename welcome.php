<!DOCTYPE html>
<html>
<body>

<?php
    session_start();

    //check if session is logged
    if( !isset($_SESSION['isLoggedIn']) ) {
        header("Location: index.php");
        die( "Login required.");
    }
?>

<?php if(isset($_SESSION['isAdmin'])) {
      echo "You have Admin Privileges"; ?>
      <li><a href="admin.php">Admin Functions</a></li>
<?php } ?>

<h1 style="text-align:center; padding-top: 100px">Welcome Back, 
<?php echo $_SESSION["uid"]; ?>
</h1>

<?php 

    //connect to SQL database
    require_once 'config.php';
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($mysqli->connection_error) { die("Connection failed: " . $mysqli->connect_error); }

    //SHOWING DB
    if(isset($_POST['show'])){
      $sql = "SELECT * FROM form";
      if ($showing = $conn->query($sql)){

        while ($row = $showing->fetch_assoc()) {
          $col1 =$row["form_id"];
          $col2 = $row["user_id"];
          $col3 = $row["comment"];

          echo "" . $col1 . 
          ". " . $col2 . 
          " said: " . $col3 . "<br>";
        }
      }
    }

    //LOGOUT
    if(isset($_POST['logout'])) {
      session_destroy();
      $_SESSION['isLoggedIn'] = false;
      $_SESSION['uid'] = "";

      header("Location: index.php");
    }

    //COMMENT
    if(isset($_POST['submit'])){
      $text = $_POST['comment'];
      $uid = $_SESSION['uid'];
      $sql = "INSERT INTO form (comment, user_id) VALUES ('$text', '$uid')";
      $show = "SELECT comment FROM form";

      if($result = $conn->query($sql)){
        echo "Adding Successful";
        }
       else {echo "Not Added!";}
    }

?>

<form style="text-align:center; padding:30px;" action="welcome.php" method="post">
  <!-- submit button -->
  <label for="comment">Comment:</label>
  <textarea id="comment" name="comment" rows="5" cols="60" ></textarea>
  <input name="submit" type="submit" value="Submit" />
  <input name="show" type="submit" value="Show" />
</form>

<form style="text-align:center; padding:30px;" action="welcome.php" method="post">
  <input name="logout" type="submit" value="Logout" />
</form>

</body>
</html>