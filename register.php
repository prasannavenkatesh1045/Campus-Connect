<?php
require_once "config.php";
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name=trim($_POST['name'] ?? ''); $reg=trim($_POST['register_number'] ?? '');
    $email=trim($_POST['email'] ?? ''); $dept=trim($_POST['department'] ?? '');
    $pass=$_POST['password'] ?? '';
    if (!$name || !$reg || !$email || !$dept || strlen($pass)<8) $error="Complete every field. Password must contain at least 8 characters.";
    else {
        try {
            $q=$pdo->prepare("INSERT INTO STUDENT(name,register_number,email,department,password_hash) VALUES(?,?,?,?,?)");
            $q->execute([$name,$reg,$email,$dept,password_hash($pass,PASSWORD_DEFAULT)]);
            header("Location: login.php?registered=1"); exit;
        } catch(PDOException $e) { $error="Registration failed. The register number or email may already exist."; }
    }
}
$page_title="Student Registration"; include "includes/header.php";
?>
<h1>Student Registration</h1><?php if($error): ?><p class="alert"><?= h($error) ?></p><?php endif; ?>
<form method="post" class="form">
<label>Full name<input name="name" required></label>
<label>Register number<input name="register_number" required></label>
<label>Email<input type="email" name="email" required></label>
<label>Department<input name="department" required></label>
<label>Password (minimum 8 characters)<input type="password" name="password" minlength="8" required></label>
<button class="btn">Create account</button></form>
<?php include "includes/footer.php"; ?>
