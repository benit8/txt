<?php

namespace Core;

class Controller
{
	protected $model;
	private $view;
	private $vars = [];
	private $files = [];

	public function __construct()
	{}

	public function loadModel(string $model, ...$args)
	{
		require_once(ROOT . "App/Models/$model.php");

		$name = "\\App\\Models\\$model";
		$this->model = new $name(...$args);
	}

	public function setVar(string $name, $var)
	{
		$this->vars[$name] = $var;
	}

	public function setVars(array $vars)
	{
		$this->vars = array_merge($this->vars, $vars);
	}

	public function loadFile(string $file)
	{
		$this->files[] = $file;
	}

	public function loadFiles(array $files)
	{
		$this->files = array_merge($this->files, $files);
	}

	public function render($filename, $layout = 'default')
	{
		$parts = explode('\\', get_class($this));

		$this->view = new View(end($parts), $layout);
		$this->switchFilesToView();
		$this->view->setVars($this->vars);
		$this->view->render($filename);
	}

	private function switchFilesToView()
	{
		foreach ($this->files as $file) {
			$filepath = ROOT . "public/$file";
			$ext = pathinfo($filepath, PATHINFO_EXTENSION);
			switch ($ext) {
				case 'css':
					$this->view->loadStyle($file);
					break;
				case 'js':
					$this->view->loadScript($file);
					break;
				default:
					break;
			}
		}
	}
}