<?php

namespace Core;

class Config
{
	private function __construct()
	{}

	const database = [
		'host' => 'db',
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