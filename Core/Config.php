<?php

namespace Core;

class Config
{
	private function __construct()
	{}

	const database = [
		'host' => '127.0.0.1',
		'user' => 'root',
		'pass' => 'ascent',
		'name' => 'txt'
	];

	const site = [
		'title' => 'TXT',
		'lead' => "Simple textboard engine",
		'desc' => "",
		'url' => ""
	];
}