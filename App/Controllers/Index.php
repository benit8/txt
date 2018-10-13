<?php

namespace App\Controllers;

class Index extends \Core\Controller
{
	public function __construct()
	{
		$this->loadModel('Boards');
	}

	public function index()
	{
		$boards = $this->model->getBoards();

		$this->loadFile('css/index.css');
		$this->setVars(['boards' => $boards]);
		$this->render('index');
	}
}