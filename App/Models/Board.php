<?php

namespace App\Models;

use \Core\Database;
use \App\Models\Post as PostModel;

class Board extends \Core\Model
{
	private $board;

	public function __construct($board)
	{
		$this->board = $board;

		parent::__construct();
	}

	public function exists()
	{
		$stmt = $this->db->fetch(
			"SELECT `title`
			 FROM `boards`
			 WHERE `id` = ?",
			$this->board
		);

		return $stmt !== false;
	}

	public function getTitle()
	{
		return $this->db->fetch(
			"SELECT `title`
			 FROM `boards`
			 WHERE `id` = ?",
			$this->board
		)->title;
	}

	public function getFullTitle()
	{
		return "/$this->board/ - " . $this->getTitle($this->board);
	}

	public function getThreads()
	{
		$threads = $this->db->fetchAll("
			SELECT *
			 FROM `posts`
			 WHERE `board` = ? AND `parent` IS NULL
			 ORDER BY `sticky` DESC, `last_bump` DESC",
			$this->board
		);

		foreach ($threads as $thread) {
			$thread->posted_diff = PostModel::passedTimeSince($thread->date_posted);
			$thread->bump_diff = PostModel::passedTimeSince($thread->last_bump);

			$thread->date_posted = PostModel::dateToLocale($thread->date_posted);
			$thread->last_bump = PostModel::dateToLocale($thread->last_bump);
		}

		return $threads;
	}

	public function insertThread($vars)
	{
		return $this->db->query(
			"INSERT INTO `posts` (`board`, `content`, `subject`, `ip`)
			 VALUES (?, ?, ?, ?)",
			$this->board, $vars['content'], $vars['subject'], $_SERVER['REMOTE_ADDR']
		);
	}
}