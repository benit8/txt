<!DOCTYPE html>
<html xmlns:og="http://ogp.me/ns#">
	<head>
		<title><?= \Core\Config::site['title'] ?></title>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<meta property="og:type" content="website">
		<meta property="og:title" content="<?= \Core\Config::site['title'] ?> - <?= \Core\Config::site['lead'] ?>">
		<meta property="og:site_name" content="<?= \Core\Config::site['title'] ?>">
		<meta property="og:description" content="<?= \Core\Config::site['desc'] ?>">
		<meta property="og:image" content="<?= WEBROOT ?>images/og.png">
		<meta property="og:url" content="<?= \Core\Config::site['url'] ?>">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link rel="stylesheet" href="<?= WEBROOT ?>css/default.css">
		<?php foreach ($styles as $style): ?>
			<link rel="stylesheet" href="<?= $style ?>">
		<?php endforeach; ?>
		<link rel="icon" href="<?= WEBROOT ?>images/favicon.ico"/>
	</head>
	<body>
		<main role="main">
			<div class="container">