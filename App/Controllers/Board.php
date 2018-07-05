<?php

namespace App\Controllers;

use \App\Validators\FormValidator;

class Board extends \Core\Controller
{
	public function __construct()
	{
		$this->loadModel('Boards');
		$this->setVars(['boards' => $this->model->getBoards()]);
	}

	public function index($board)
	{
		$this->loadModel('Board', $board);

		if (!$this->model->exists())
			return false;

		$this->setVars([
			'title' => $this->model->getFullTitle(),
			'threads' => $this->model->getThreads()
		]);

		$this->loadFiles([
			"css/board.css",
			"js/board.js"
		]);

		$this->render('index', 'boards');
	}

	public function createThread($board)
	{
		$this->loadModel('Board', $board);

		if (!$this->model->exists())
			return false;

		$fv = new FormValidator($_POST);
		$fv->required('subject', 'content');
		$fv->notEmpty('content');

		$res = [];
		if (!$fv->isValid()) {
			$res['status'] = 'failure';
			$res['errors'] = $fv->getErrors();
		}
		else {
			$vars = $fv->getVars();

			if ($this->model->insertThread($vars))
				$res['status'] = 'success';
			else {
				$res['status'] = 'failure';
				$res['errors'][''] = "Database error.";
			}
		}

		echo json_encode($res);
	}
}