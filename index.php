<?php
  require_once("utility.php");

  session_start();

  if(empty($_SESSION["me"])){
    header("Location: user_signup/login.php");
    exit();
  }

  $id = $_SESSION["id"];

  $dbh = dbh();
  $stmt = $dbh->query("SELECT * FROM posts WHERE user_id = '$id'");
  $posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>index.php</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css" />
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body
    <h3>HELLO! "<?php echo $_SESSION['name'] ?>"</h3><br>
    <a href="user_signup/signout.php">|SIGN OUT|</a>
  </body>
</html>
