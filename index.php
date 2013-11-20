<?php
  require_once("utility.php");

  session_start();

  if(empty($_SESSION["me"])){
    header("Location: user_signup/login.php");
    exit();
  }

  $id = $_SESSION["id"];

  $dbh = dbh();
  $stmt = $dbh->query("SELECT * FROM tasks WHERE user_id = '$id'");
  $tasks = $stmt->fetchAll();
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
          <li><a href="index.php">|HOME|</a></li>
          <li><a href="post.php">|MAKE|</a></li>
          <li><a href="user_signup/signout.php">|Sign Out|</a></li>
        </ul>
      </nav>
    </header>

    <div id="container">
      <?php foreach($tasks as $task) { ?>
        <p> <?php echo $task['title']; ?> </p>
        <p> <?php echo $task['body']; ?> </p>
        <p> <?php echo $task['closed_at']; ?> </p>
        <form method="post" action="edit.php">
          <button type="submit" class="btn btn-info" name="edit" value=<?php echo $task["id"] ?>>Edit</button>
        </form>
        <form method="post" action="delete.php">
          <button type="submit" class="btn btn-info" name="delete" value=<?php echo $task["id"] ?>>Delete</button>
        </form>
        <p>-------------------------------------------------------------</p>
      <?php } ?>
    </div>
  </body>
</html>
