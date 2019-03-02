<?php
	const DEFAULT_DIR = 'Frontend';
	const DEFAULT_APP = 'FrontendApplication';
 
	// Si l'application n'est pas valide, on va charger l'application par défaut qui se chargera de générer une erreur 404
	if (!isset($_GET['dir']) || !file_exists(__DIR__.'/../App/'.$_GET['dir'])) 
	{
		$_GET['dir'] = DEFAULT_DIR;

		if(!isset($_GET['app'])) {
			$_GET['app'] = DEFAULT_APP;
		}
	}

	require_once __DIR__.'/../vendor/autoload.php';

	$appClass = 'App\\'.$_GET['dir'].'\\'.$_GET['app'];
	
	$app = new $appClass;
	$app->run();
?>