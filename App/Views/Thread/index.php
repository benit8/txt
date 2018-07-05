<div class="thread">
	<?php foreach ($replies as $i => $reply): ?>
		<div class="reply<?php if ($i == 0) echo " op"; ?>" id="p<?= $reply->id ?>">
			<?php if ($i == 0) echo "<span class=\"subject\">$reply->subject</span>"; ?>
			<span class="infos">
				<a href="#p<?= $reply->id ?>" class="anchor" title="Link to this post">#</a>
				<a href="#" class="id" title="Reply to this post"><?= $reply->id ?></a>
				<span class="date"><?= $reply->date_posted ?></span>
			</span>
			<div class="content"><?= $reply->content ?></div>
		</div>
	<?php endforeach; ?>
</div>

<hr>
<div class="d-flex justify-content-between">
	<div class="controls">
		<a href="<?= dirname($_SERVER['REQUEST_URI']) ?>/">Back</a> \ <a href="#top">Top</a> \ <a href="">Refresh</a>
	</div>
	<div class="reply-zone">
		<a href="#" id="RBToggler">Reply</a>
	</div>
	<span class="stats">
		<span class="replies" title="Replies"><?= $stats->replies ?></span> / <span class="ips" title="Posters"><?= $stats->IPs ?></span> / -
	</span>
</div>

<div id="replyBox" style="display: none;">
	<div class="header">
		<span>Reply box</span>
		<button type="button" id="RBClose" class="close">&times;</button>
	</div>
	<form action="" method="POST" id="replyForm">
		<textarea name="content" class="form-control" placeholder="Reply" required></textarea>
		<button type="submit" class="btn btn-primary btn-block">Send</button>
	</form>
</div>