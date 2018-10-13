<?php

namespace App\Models;

use \Core\Database;

class Boards extends \Core\Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getBoards()
	{
		return $this->db->fetchAll(
			"SELECT *
			 FROM `boards`
			 ORDER BY `id`"
		);
	}

	public function getBoardList()
	{
		$boards = $this->getBoards();

		$list = "<a href=\"" . WEBROOT . "{$boards[0]->id}/\" title=\"{$boards[0]->title}\">{$boards[0]->id}</a>";
		for ($i = 1; $i < count($boards); $i++)
			$list .= "\<a href=\"" . WEBROOT . "{$boards[$i]->id}/\" title=\"{$boards[$i]->title}\">{$boards[$i]->id}</a>";

		return $list;
	}
}