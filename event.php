<?php
require_once "config.php"; $id=(int)($_GET['id']??0);
$q=$pdo->prepare("SELECT * FROM EVENT WHERE event_id=? AND publication_status='Published'"); $q->execute([$id]); $event=$q->fetch();
if(!$event){http_response_code(404); die("Event not found.");}
$message="";
if($_SERVER['REQUEST_METHOD']==='POST'){
 require_login();
 try{$q=$pdo->prepare("INSERT INTO REGISTRATION(student_id,event_id) VALUES(?,?)");$q->execute([$_SESSION['user_id'],$id]);$message="You have registered successfully.";}
 catch(PDOException $e){$message="You are already registered for this event.";}
}
$page_title=$event['title']; include "includes/header.php";
?>
<a href="index.php">← Back to events</a><article class="detail"><span class="tag"><?= h($event['category']) ?></span>
<h1><?= h($event['title']) ?></h1><p><?= h($event['description']) ?></p>
<p><b>Date:</b> <?= h($event['event_date']) ?> · <?= h($event['event_time']) ?></p>
<p><b>Venue:</b> <?= h($event['venue']) ?></p><p><b>Eligibility:</b> <?= h($event['eligibility']) ?></p>
<?php if($message): ?><p class="success"><?= h($message) ?></p><?php endif; ?>
<?php if(!empty($_SESSION['user_id'])): ?><form method="post"><button class="btn">Register for event</button></form>
<?php else: ?><a class="btn" href="login.php">Login to register</a><?php endif; ?>
</article><?php include "includes/footer.php"; ?>
