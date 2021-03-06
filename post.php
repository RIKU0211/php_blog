
<?php
  require_once("utility.php");

  session_start();

  $error = array();
  $title = "";
  $body = "";

  if(@$_POST["submit"]){
    $title = $_POST["title"];
    $body = $_POST["body"];
    $closed_at = $_POST["closed_at"];

    if(empty($title)){
      $error[] = "empty title";
    }

    if(mb_strlen($title) > 50){
      $error[] = "write title within 50 characters";
    }

    if(empty($body)){
      $error[] = "empty body";
    }

    if(empty($error)){
      $id = $_SESSION["id"];
      $dbh = dbh();
      
      $stmt = $dbh->prepare("INSERT INTO tasks(user_id, title, body, created_at, closed_at) VALUES(:id, :title, :body, NOW(), :closed_at)"); 
      $stmt->bindValue(":id", $id, PDO::PARAM_INT);
      $stmt->bindValue(":title", $title, PDO::PARAM_STR);
      $stmt->bindValue(":body", $body, PDO::PARAM_STR);
      $stmt->bindValue(":closed_at", $closed_at, PDO::PARAM_STR);
      $stmt->execute();

      header("Location: index.php");
      exit();
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Post</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css" />
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/post.css" />
    <style type="text/css">
      body {
        margin: 10px;
      }
      
      .label { margin: 10px 0 10px 0 }
    </style>
  </head>
  <body>
    <form method="post" action="post.php">
      <div id="post">
        <h2>Make Todo</h2>                                                   
        <!-- error messages -->
        <?php if(!empty($error)) { foreach($error as $i) { echo h($i) . "<br>"; } } ?>
        <span class="label label-info">Title</span><br>
        <input type="text" name="title" size="30" placeholder="title" value="<?php echo $title ?>" /><br>
        <span class="label label-info">Body</span><br>
        <textarea name="body" rows="8" cols="30" placeholder="body"><?php echo $body ?></textarea><br> 
        <span class="label label-info">Closing day</span><br>
        <input type="date" name="closed_at" value="2013-01-01">
        <br><br>
        <button type="submit" name="submit" class="btn btn-primary" value="Post">Post</button>
        <button type="button" name="home" class="btn btn-success" onclick="location.href='index.php'">Home</button>
      </div>
    </form>
  </body>
</html>
