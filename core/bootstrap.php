<?php

error_reporting(E_ALL & ~E_NOTICE);

require 'app/Services/ServiceProviders.php';
require 'app/Services/Helpers.php';

$entityManager = em();

//Router
$router = router();

require 'routes/guest-routes.php';

$authentication = new App\Middlewares\Authentication();

if ($authentication->passed()) {
	$user = new App\Models\User($authentication);

	if ($user->isAdmin()) {
		require 'routes/admin-routes.php';
		require 'routes/loged-user-routes.php';
	} elseif ($user->isUser()) {
		require 'routes/loged-user-routes.php';
	}
}

$router->run();