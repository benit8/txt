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
}