<?php
require_once "config.php"; require_admin();
if(isset($_GET['publish'])){$q=$pdo->prepare("UPDATE EVENT SET publication_status='Published' WHERE event_id=?");$q->execute([(int)$_GET['publish']]);header("Location: admin.php");exit;}
if(isset($_GET['draft'])){$q=$pdo->prepare("UPDATE EVENT SET publication_status='Draft' WHERE event_id=?");$q->execute([(int)$_GET['draft']]);header("Location: admin.php");exit;}
$events=$pdo->query("SELECT E.*, (SELECT COUNT(*) FROM REGISTRATION R WHERE R.event_id=E.event_id) AS total_registrations FROM EVENT E ORDER BY event_date DESC")->fetchAll();
$page_title="Admin Dashboard"; include "includes/header.php";
?>
<h1>Admin Dashboard</h1><p>Welcome, <?= h($_SESSION['admin_name']) ?>.</p>
<p><a class="btn" href="event_create.php">+ Create event</a></p>
<div class="card"><table><tr><th>Event</th><th>Date</th><th>Status</th><th>Registrations</th><th>Action</th></tr>
<?php foreach($events as $e): ?><tr><td><?= h($e['title']) ?></td><td><?= h($e['event_date']) ?></td><td><?= h($e['publication_status']) ?></td><td><?= (int)$e['total_registrations'] ?></td><td>
<?php if($e['publication_status']==='Published'): ?><a href="?draft=<?= (int)$e['event_id'] ?>">Unpublish</a><?php else: ?><a href="?publish=<?= (int)$e['event_id'] ?>">Publish</a><?php endif; ?>
</td></tr><?php endforeach; ?></table></div>
<?php include "includes/footer.php"; ?>
