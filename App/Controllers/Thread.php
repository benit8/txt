<?php

namespace App\Controllers;

use \App\Validators\FormValidator;

class Thread extends \Core\Controller
{
	public function __construct()
	{
		$this->loadModel('Boards');
		$this->setVars(['boardList' => $this->model->getBoardList()]);
	}

	public function index($board, $thread)
	{
		$this->loadModel('Thread', $board, $thread);

		if (!$this->model->exists())
			return false;

		$op = $this->model->getOP($board, $thread);
		$replies = $this->model->getReplies($board, $thread);

		array_unshift($replies, $op);
		array_map([$this->model, 'formatPost'], $replies);

		$stats = $this->model->getStats();

		$this->setVars([
			'replies' => $replies,
			'stats' => $stats,
			'op' => $op
		]);

		$this->loadFile([
			"css/thread.css",
			"js/thread.js"
		]);

		if (!($op->locked || $op->archived))
			$this->loadFile("js/replyBox.js");

		$this->render('index', 'boards');
	}

	public function insertReply($board, $thread)
	{
		$this->loadModel('Thread', $board, $thread);

		if (!$this->model->exists())
			return false;

		$op = $this->model->getOP();
		if ($op->locked || $op->archived)
			return false;

		$res = [];
		$fv = new FormValidator($_POST);
		$fv->notEmpty('content');
		if (!$fv->isValid()) {
			$res['status'] = 'failure';
			$res['errors'] = $fv->getErrors();
		}
		else {
			$vars = $fv->getVars();

			if ($this->model->insertReply($vars))
				$res['status'] = 'success';
			else {
				$res['status'] = 'failure';
				$res['errors'][''] = "Database error.";
			}
		}

		echo json_encode($res);
	}
}