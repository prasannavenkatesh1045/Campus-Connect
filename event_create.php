<?php
require_once "config.php"; require_admin(); $error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
 $title=trim($_POST['title']??'');$cat=trim($_POST['category']??'');$desc=trim($_POST['description']??'');
 $date=$_POST['event_date']??'';$time=trim($_POST['event_time']??'');$venue=trim($_POST['venue']??'');
 if(!$title||!$cat||!$desc||!$date||!$venue)$error="Please complete all required fields.";
 else{$q=$pdo->prepare("INSERT INTO EVENT(title,category,description,event_date,event_time,venue,publication_status,created_by) VALUES(?,?,?,?,?,?,?,?)");
 $q->execute([$title,$cat,$desc,$date,$time,$venue,$_POST['publication_status']??'Draft',$_SESSION['admin_id']]);header("Location: admin.php");exit;}
}
$page_title="Create Event"; include "includes/header.php";
?>
<h1>Create Event</h1><?php if($error): ?><p class="alert"><?= h($error) ?></p><?php endif; ?>
<form method="post" class="form"><label>Event title<input name="title" required></label>
<label>Category<input name="category" required></label><label>Description<textarea name="description" required></textarea></label>
<label>Date<input type="date" name="event_date" required></label><label>Time<input name="event_time" value="09:30 AM - 04:30 PM"></label>
<label>Venue<input name="venue" required></label><label>Publish status<select name="publication_status"><option>Draft</option><option>Published</option></select></label>
<button class="btn">Save event</button></form><?php include "includes/footer.php"; ?>
