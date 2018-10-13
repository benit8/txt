<div class="thread">
	<div class="subject">
		<?php if ($replies[0]->archived): ?><i class="fa fa-sm fa-archive" title="Archived"></i><?php endif; ?>
		<?php if ($replies[0]->sticky): ?><i class="fa fa-sm fa-thumbtack" title="Pinned"></i><?php endif; ?>
		<?php if ($replies[0]->locked): ?><i class="fa fa-sm fa-lock" title="Locked"></i><?php endif; ?>
		<?= $replies[0]->subject ?>
	</div>

	<?php foreach ($replies as $i => $reply): ?>
		<div class="reply<?php if ($i == 0) echo " op"; ?>" id="p<?= $reply->id ?>">
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
		<?php if (!($op->locked || $op->archived)): ?>
			<a href="#" id="RBToggler">Reply</a>
		<?php else: ?>
			Thread is closed
		<?php endif; ?>
	</div>
	<span class="stats">
		<span class="replies" title="Replies"><?= $stats->replies ?></span> / <span class="ips" title="Posters"><?= $stats->IPs ?></span> / -
	</span>
</div>

<?php if (!($op->locked || $op->archived)): ?>
<div id="replyBox" style="display: none;">
	<div class="header">
		<small>Reply box</small>
		<button type="button" id="RBClose" class="close">&times;</button>
	</div>
	<form action="" method="POST" id="replyForm">
		<textarea name="content" class="form-control" placeholder="Reply" required></textarea>
		<button type="submit" class="btn btn-primary btn-sm btn-block">Send</button>
	</form>
</div>
<?php endif; ?>