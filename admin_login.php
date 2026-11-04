<?php
require_once "config.php"; $error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
 $username=trim($_POST['username']??''); $pass=$_POST['password']??'';
 $q=$pdo->prepare("SELECT * FROM ADMIN WHERE username=?"); $q->execute([$username]); $a=$q->fetch();
 if($a && password_verify($pass,$a['password_hash'])){
  session_regenerate_id(true); $_SESSION['admin_id']=$a['admin_id']; $_SESSION['admin_name']=$a['username'];
  header("Location: admin.php"); exit;
 } else $error="Invalid admin username or password.";
}
$page_title="Admin Login"; include "includes/header.php";
?>
<h1>Administrator Login</h1><?php if($error): ?><p class="alert"><?= h($error) ?></p><?php endif; ?>
<form method="post" class="form"><label>Username<input name="username" required></label>
<label>Password<input type="password" name="password" required></label><button class="btn">Login</button></form>
<?php include "includes/footer.php"; ?>
