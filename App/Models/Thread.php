<?php

namespace App\Models;

use \Core\Database;
use \App\Models\Post as PostModel;

class Thread extends \Core\Model
{
	private $board;
	private $thread;

	public function __construct($board, $thread)
	{
		$this->board = $board;
		$this->thread = $thread;

		parent::__construct();
	}

	public function exists(): bool
	{
		return $this->getOP() !== false;
	}

	public function isSticky(): bool
	{
		return $this->getOP()->sticky !== '0';
	}

	public function isLocked(): bool
	{
		return $this->getOP()->locked !== '0';
	}

	public function isArchived(): bool
	{
		return $this->getOP()->archived !== '0';
	}

	public function getOP()
	{
		return $this->db->fetch(
			"SELECT *
			 FROM `posts`
			 WHERE `board` = ? AND `id` = ? AND `parent` IS NULL",
			$this->board, $this->thread
		);
	}

	public function getReplies()
	{
		return $this->db->fetchAll(
			"SELECT *
			 FROM `posts`
			 WHERE `board` = ? AND `parent` = ?
			 ORDER BY `id`",
			$this->board, $this->thread
		);
	}

	public function getStats()
	{
		$stats = $this->db->fetch(
			"SELECT COUNT(`id`) as `replies`, COUNT(DISTINCT(`ip`)) as `IPs`
			 FROM `posts`
			 WHERE `board` = ? AND (`id` = ? OR `parent` = ?)",
			$this->board, $this->thread, $this->thread
		);

		// Exclude OP from reply count
		$stats->replies--;

		return $stats;
	}

	public function insertReply($vars)
	{
		$stmt = $this->db->query(
			"INSERT INTO `posts` (`board`, `parent`, `content`, `ip`)
			 VALUES (?, ?, ?, ?)",
			$this->board, $this->thread, $vars['content'], $_SERVER['REMOTE_ADDR']
		);

		if (!$stmt)
			return false;

		$upd = $this->db->query(
			"UPDATE `posts`
			 SET `last_bump` = CURRENT_TIMESTAMP
			 WHERE `board` = ? AND `id` = ?",
			$this->board, $this->thread
		);

		return true;
	}

	public function formatPost($reply)
	{
		$reply->content = nl2br($reply->content);
		$reply->content = preg_replace_callback_array([
			'/>>>([\w]+)/m' => [$this, 'replaceBoardLink'],
			'/>>([\d]+)/m' => [$this, 'replacePostLink'],
			'/^>(.*)$/m' => [$this, 'replaceGreentext'],
			'/\[spoiler\](.*)\[\/spoiler\]/s' => [$this, 'replaceSpoiler'],
			'/\[code\](.*)\[\/code\]/s' => [$this, 'replaceCode'],

		], $reply->content);

		$reply->date_posted = PostModel::dateToLocale($reply->date_posted);

		return $reply;
	}

	/// Regex replace callbacks ///////////////////////////////////////////////

	private function replaceBoardLink($m)
	{
		$id = $m[1];

		if ($this->db->query("SELECT * FROM `boards` WHERE `id` = ?", $id))
			return "<a href=\"/$id/\" class=\"quotelink\">&gt;&gt;&gt;/$id/</a>";

		return $m[0];
	}

	private function replacePostLink($m)
	{
		$id = $m[1];
		$post = $this->db->fetch("SELECT * FROM `posts` WHERE `board` = ? AND `id` = ?", $this->board, $id);
		if (!$post)
			return "<span class=\"deadlink\">&gt;&gt;$id</span>";

		$markers = [];
		$url = "";

		if ($post->id == $this->thread)
			$markers[] = "(OP)";

		if ($post->ip == $_SERVER['REMOTE_ADDR'])
			$markers[] = "(You)";

		if ($post->parent != $this->thread && $post->id != $this->thread) {
			$markers[] = "→";
			$url = "$post->parent";
		}

		return "<a href=\"$url#p$post->id\" class=\"quotelink\">&gt;&gt;$post->id " . implode(' ', $markers) . "</a>";
	}

	private function replaceGreentext($m)
	{
		return "<span class=\"greentext\">&gt;{$m[1]}</span>";
	}

	private function replaceSpoiler($m)
	{
		while (preg_match('/\[spoiler\](.*)\[\/spoiler\]/s', $m[1]))
			$m[1] = preg_replace('/\[spoiler\](.*)\[\/spoiler\]/s', "<span class=\"spoiler\">$1</span>", $m[1]);
		return "<span class=\"spoiler\">{$m[1]}</span>";
	}

	private function replaceCode($m)
	{
		$code = str_replace('<br />', '', $m[1]);
		$code = htmlspecialchars($code);
		return "<pre>$code</pre>";
	}
}