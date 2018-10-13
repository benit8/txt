<div class="card text-center">
	<div class="card-body">
		<h2><?= $title ?></h2>
		<hr>

		<a href="#" id="threadFormToggler">Start a new thread</a>
		<div class="w-25 mt-3 ml-auto mr-auto" id="threadFormContainer" style="display: none;">
			<form  method="POST"action="" id="threadForm">
				<input type="text" class="form-control" name="subject" placeholder="Subject" />
				<textarea class="form-control" name="content" placeholder="Comment"></textarea>
				<button type="submit" class="btn btn-primary btn-block">Send</button>
			</form>
		</div>

		<table class="thread-list table table-sm table-striped table-hover mt-3">
			<thead>
				<tr>
					<th>Thread</th>
					<th>Creation</th>
					<th>Last Bump</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($threads as $t): ?>
					<tr href="<?= $t->id ?>" class="<?= $t->archived ? "archived" : '' ?>">
						<td>
							<?php if ($t->archived): ?><i class="fa fa-sm fa-archive" title="Archived"></i><?php endif; ?>
							<?php if ($t->sticky): ?><i class="fa fa-sm fa-thumbtack" title="Pinned"></i><?php endif; ?>
							<?php if ($t->locked): ?><i class="fa fa-sm fa-lock" title="Locked"></i><?php endif; ?>
							<?= ($t->subject ? "<b>$t->subject</b>: " : "") . $t->content ?>
						</td>
						<td title="<?= $t->posted_diff ?>"><?= $t->date_posted ?></td>
						<td title="<?= $t->bump_diff ?>"><?= $t->last_bump ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>