<?php

namespace App\Models;

class Post extends \Core\Model
{
	public static function passedTimeSince($time, $precision = 2)
	{
		if (!is_int($time))
			$time = strtotime($time);

		$diff = time() - $time;

		$steps = [
			['second', 60],
			['minute', 60],
			['hour', 24],
			['day', 7],
			['month', 30],
			['year', 12],
			['decade', 10]
		];

		$diffs = [];
		$div = 1;
		for ($i = 0; $i < count($steps) && $diff >= $div; $i++) {
			$val = ($diff / $div) % $steps[$i][1];
			$diffs[] = "$val {$steps[$i][0]}" . ($val > 1 ? "s" : "");
			$div *= $steps[$i][1];
		}


		$str = "";
		for ($i = count($diffs) - 1; $i > 0 && $i > count($diffs) - $precision; $i--)
			$str .= "$diffs[$i] ";
		if ($i >= 0)
			$str .= "and {$diffs[$i]} ago";

		return $str;
	}

	public static function dateToLocale($date)
	{
		if (!is_int($date))
			$date = strtotime($date);

		return strftime("%c", $date);
	}
}