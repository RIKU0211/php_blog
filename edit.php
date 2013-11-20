<?php
  require_once("utility.php");

  $dbh = dbh();

  if(@$_POST["edit"]){
    $id = $_POST["edit"];
  }

  if(@$_POST["submit"]){
    $stmt = $dbh->prepare("UPDATE tasks SET title = :title, body = :body, created_at = NOW(), closed_at = :closed_at WHERE id = :id");
    $params = array(":id" => $_POST["submit"],
                    ":title" => $_POST["title"],
                    ":body" => $_POST["body"],
                    ":closed_at" => $_POST["closed_at"]);
    $stmt->execute($params);

    header("Location: index.php");
    exit();
  }

  $stmt = $dbh->query("SELECT * FROM tasks WHERE id = '$id'");
  $edit = $stmt->fetchAll();
  $title = $edit[0]["title"];
  $body = $edit[0]["body"];
  $closed_at = $edit[0]["closed_at"];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Edit</title> 
    <link rel"stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel"stylesheet" href="bootstrap/css/bootstrap-responsive.min.css" />
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>   
    <link rel"stylesheet" href="css/post.css" />
    <style type="text/css">
      body {
        margin: 10px;
      }

      .label{ margin: 10px 0 10px 0}
    </style>
 </head>
 <body>
   <h2>Edit Article</h2>
   <form method="post" action="edit.php">
      <span class="label label-info">Title</span><br>
     <input type="text" name="title" size="30" placeholder="title" value="<?php echo $title ?>" /><br>
     <span class="label label-info">Body</span><br>
     <textarea name="body" rows="8" cols="30"><?php echo $body?></textarea><br>
     <span class="label label-info">Closing day</span><br>
     <input type="date" name="closed_at" value=<?php echo $closed_at ?>>
     <br><br>
     <button type="submit" name="submit" class="btn btn-primary" value="<?php echo $id ?>">Edit</button>
     <button type="button" name="home" class="btn btn-primary" onclick="location.href='index.php'">Home</button>
   </form>
 </body>
</html>
