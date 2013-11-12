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

  $stmt = $dbh->query("SELECT * FROM comments");
  $comments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>index.php</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css" />
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <header id="header">
      <hgroup>
        <h2>PHP BLOG</h2>
        <h3>HELLO! "<?php echo $_SESSION['name'] ?>"</h3><br>
      </hgroup>
      <nav>
        <ul id="nav">
          <li><a href="user_signup/signout.php">|SIGN OUT|</a></li>
          <li><a href="post.php">|POST|</a></li>
          <li><a href="user_controlloer/signout.php">|Sign Out|</a></li>
        </ul>
      </nav>
    </header>

  </body>
</html>
