<div class="py-5 text-center">
	<h1><?= \Core\Config::site['title'] ?></h1>
	<p class="lead"><?= \Core\Config::site['lead'] ?></p>
</div>

<section>
	<h3>Board list</h3>
	<hr>

	<div class="board-container">
		<?php foreach ($boards as $board): ?>
			<a href="<?= $board->id ?>/" class="d-block"><?= $board->title ?></a>
		<?php endforeach; ?>
	</div>
</section>

<section>
	<h3>Rules</h3>
	<hr>

	<ul>
		<li>No CP</li>
	</ul>
</section>