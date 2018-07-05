<?php

namespace App\Validators;

use \Core\Database;

class BanValidator
{
	public function __construct()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$db = Database::getInstance();

		$record = $db->fetch("SELECT * FROM `ips` WHERE `ip` = ?", $ip);

		if (!$record)
			$db->query("INSERT INTO `ips` (`ip`) VALUES (?)", $ip);
		else if ($record->status == 'banned') {
			if (!empty($record->expire) && strtotime($record->expire) <= time())
				$db->query("UPDATE `ips` SET `status` = 'good', `expire` = NULL, `reason` = NULL WHERE `ip` = ?", $ip);
			else {
				$dump = $this->dumpRecord($record);
				echo nl2br($dump);
				die;
			}
		}
	}

	private function dumpRecord($record)
	{
		ob_start();

		printf("You are banned :(\n");
		printf("Reason: %s\n", ($record->reason ?: "<i>None specified</i>"));
		printf("Date of unban: %s\n", ($record->expire ?: "<i>None specified</i>"));

		return ob_get_clean();
	}
}