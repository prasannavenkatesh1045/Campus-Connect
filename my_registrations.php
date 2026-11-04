<?php
require_once "config.php"; require_login();
$q=$pdo->prepare("SELECT E.title,E.event_date,E.venue,R.status,R.registration_time FROM REGISTRATION R JOIN EVENT E ON E.event_id=R.event_id WHERE R.student_id=? ORDER BY R.registration_time DESC");
$q->execute([$_SESSION['user_id']]); $rows=$q->fetchAll();
$page_title="My Registrations"; include "includes/header.php";
?>
<h1>My Registrations</h1><div class="card"><table><tr><th>Event</th><th>Date</th><th>Venue</th><th>Status</th></tr>
<?php foreach($rows as $r): ?><tr><td><?= h($r['title']) ?></td><td><?= h($r['event_date']) ?></td><td><?= h($r['venue']) ?></td><td><?= h($r['status']) ?></td></tr><?php endforeach; ?>
</table><?php if(!$rows): ?><p>You have not registered for any events.</p><?php endif; ?></div>
<?php include "includes/footer.php"; ?>
