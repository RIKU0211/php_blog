<?php
  require_once("../utility.php");

  session_start();

  // valid session
  if(!empty($_SESSION["me"])){
    header("Location: ../index.php");
    exit();
  }

  if($_SERVER["REQUEST_METHOD"] != "POST"){
    setToken();
  } else {
    checkToken();

    $name = $_POST["name"];
    $password = $_POST["password"];
    $dbh = dbh();
    $error= array();

    if(empty($name)){
      $error[] = "empty name";
    }

    if(empty($password)){
      $error[] = "empty password";
    }

    if(!($me = getUser($dbh, $name, $password))){
      $error[] = "wrong user name or password";
    }

    if(empty($error)){
      session_regenerate_id(true);
      $_SESSION["me"] = $me;

      $sql = "SELECT * FROM users WHERE name = :name LIMIT 1";
      $stmt = $dbh->prepare($sql);
      $stmt->execute(array(":name" => $name));
      $user = $stmt->fetch();
      $_SESSION["id"] = $user["id"];
      $_SESSION["name"] = $user["name"];

      header("Location: ../index.php");
      exit();
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../bootstrap/css/bootstrap-responsive.min.css" />
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    <style type="text/css">
      .label{ margin: 10px 0 10px 0 }
    </style>
  </head>
  <body>
    <h2>Login</h2>
    <form method="post" action="">
      <!-- error messages -->
      <?php if(!empty($error)){ foreach($error as $i){ echo h($i) . "<br>"; } } ?>

      <span class="label label-info">User Name</span><br>
      <input type="text" name="name" placeholder="name" value="" /><br>
      <span class="label label-info">Password</span><br>
      <input type="password" name="password" placeholder="password" value="" /><br>
      <br>
      <button type="submit" name="submit" class="btn btn-primary">Login</button>
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>" />
      <button type="button" name="home" class="btn btn-success" onclick="location.href='signup.php'">Sign Up</button>
    </form>
  </body>
</html>                                              
