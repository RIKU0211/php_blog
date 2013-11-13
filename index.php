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

    <div id="container">
      <?php foreach($posts as $post) { ?>
      <div class="post">
        <!-- title -->
        <h3>
          <?php echo $post["title"] ?>
          <?php if(!empty($post["img_path"])) {
            echo "<img src=" . $post["img_path"] . " />";
          }
          ?>
        </h3>
        <hr>

        <!-- body -->
        <p><?php echo nl2br($post["body"]) ?></p>

        <!-- buttons -->
        <div id="button">
          <form method="post" action="edit.php">
            <addr title="edit">
              <button type="submit" class="btn btn-info" name="edit" value=<?php echo $post["id"] ?>>
                <i class="icon-edit idon-white"></i>
              </button>
            </addr>
          </form>
        </div>
        <br><br><br><hr>
      </div>
      <?php } ?>
    </div>
  </body>
</html>
