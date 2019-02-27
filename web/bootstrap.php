<?php
	const DEFAULT_APP = 'Frontend';
 
	// Si l'application n'est pas valide, on va charger l'application par défaut qui se chargera de générer une erreur 404
	if (!isset($_GET['app']) || !file_exists(__DIR__.'/../App/'.$_GET['app'])) 
	{
		$_GET['app'] = DEFAULT_APP;
	}

	require_once __DIR__.'/../vendor/autoload.php';

	$appClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';
	$appClass .= (isset($_GET['mode'])) ? $_GET['mode'] : '';
	
	$app = new $appClass;
	$app->run();
?>