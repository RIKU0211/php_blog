<?php
  require_once("../utility.php");

  session_start();

  if($_SERVER["REQUEST_METHOD"] != "POST"){
    setToken();
  } else {
    checkToken();

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $error = array();
    $dbh = dbh();

    if(empty($name)){
      $error[] = "empty name";
    }

    if(empty($email)){
      $error[] = "empty email";
    }

    if(empty($password)){
      $error[] = "empty password";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $error[] = "invalid email";
    }

    if(emailExists($email, $dbh)){
      $error[] = "this email is already used";
    }

    if(empty($error)){
      $sql = "INSERT INTO users (name, email, password, created_at) VALUES(:name, :email, :password, NOW())";
      $stmt = $dbh->prepare($sql);
      $params = array(":name" => $name,
                      ":email" => $email,
                      ":password" => getSha1Password($password));
      $stmt->execute($params);

      header("Location: login.php");
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
    <h2>Sign Up</h2>
    <form method="post" action="">
      <!-- error messages -->
      <?php if(!empty($error)){ foreach($error as $i){ echo h($i) . "<br>"; } } ?>

      <span class="label label-info">Name</span><br>
      <input type="text" name="name" placeholder="name" value="" /><br>
      <span class="label label-info">Email</span><br>
      <input type="text" name="email" placeholder="xxx@xxx.com" value="" /><br>
      <span class="label label-info">Password</span><br>
      <input type="password" name="password" placeholder="password" value="" /><br>
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>"
      <br>
      <button type="submit" name="submit" class="btn btn-primary">Sign Up</button>
      <button type="button" name="home" class="btn btn-success" onclick="location.href='login.php'">Back</button>
    </form>
  </body>
</html>                                              
