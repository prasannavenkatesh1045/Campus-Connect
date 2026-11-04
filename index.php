<?php
require_once "config.php";
$page_title = "Explore Events";
$stmt = $pdo->query("SELECT * FROM EVENT WHERE publication_status='Published' ORDER BY event_date ASC");
$events = $stmt->fetchAll();
include "includes/header.php";
?>
<section class="hero"><p class="eyebrow">KPRIET · CAMPUS LIFE</p><h1>Discover. Participate. Connect.</h1>
<p>Find workshops, symposiums, competitions and campus activities in one place.</p>
<a class="btn" href="register.php">Join Campus Connect</a></section>
<h2>Upcoming Events</h2>
<div class="cards">
<?php foreach ($events as $event): ?>
<article class="card"><span class="tag"><?= h($event['category']) ?></span>
<h3><?= h($event['title']) ?></h3><p><?= h($event['description']) ?></p>
<p><b>Date:</b> <?= h($event['event_date']) ?> · <?= h($event['event_time']) ?></p>
<p><b>Venue:</b> <?= h($event['venue']) ?></p>
<a class="btn small" href="event.php?id=<?= (int)$event['event_id'] ?>">View event</a></article>
<?php endforeach; ?>
<?php if (!$events): ?><p>No published events available yet.</p><?php endif; ?>
</div>
<?php include "includes/footer.php"; ?>
