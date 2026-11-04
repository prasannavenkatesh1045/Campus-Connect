<?php
require_once "config.php"; $error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
 $email=trim($_POST['email']??''); $pass=$_POST['password']??'';
 $q=$pdo->prepare("SELECT * FROM STUDENT WHERE email=?"); $q->execute([$email]); $u=$q->fetch();
 if($u && password_verify($pass,$u['password_hash'])){
  session_regenerate_id(true); $_SESSION['user_id']=$u['student_id']; $_SESSION['user_name']=$u['name'];
  header("Location: index.php"); exit;
 } else $error="Invalid email or password.";
}
$page_title="Student Login"; include "includes/header.php";
?>
<h1>Student Login</h1><?php if(isset($_GET['registered'])): ?><p class="success">Registration successful. Please log in.</p><?php endif; ?>
<?php if($error): ?><p class="alert"><?= h($error) ?></p><?php endif; ?>
<form method="post" class="form"><label>Email<input type="email" name="email" required></label>
<label>Password<input type="password" name="password" required></label><button class="btn">Login</button></form>
<?php include "includes/footer.php"; ?>
