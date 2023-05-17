<?php

$request = $_SERVER['REQUEST_URI'];

$req = explode("?", $request);

$hasErrors = null;

$docs[0] == "docs" ? $hasDocument = true : '';

isset($req[1]) ? (explode("=", $req[1])[0] == "erro" ? $hasErrors = $req[1] : "") : "";

switch ($req[0]) {

	case '':

	case '/home':
		require __DIR__ . '/controller/home_page.php';
		break;

	case '/login':
		require __DIR__ . '/controller/login_user_page.php';
		break;

	case '/logout':
		require __DIR__ . '/controller/logout.php';
		break;

	case '/login-user':
		require __DIR__ . '/controller/login_user_controller.php';
		break;

	case '/register':
		require __DIR__ . '/controller/create_user_page.php';
		break;

	case '/create-user':
		require __DIR__ . '/controller/create_user_controller.php';
		break;

	case '/search-files':
		require __DIR__ . '/controller/search_file_page.php';
		break;

	case '/view-files':
		require __DIR__ . '/controller/view_file_page.php';
		break;

	case '/submit-file':
		require __DIR__ . '/controller/submit_file_page.php';
		break;

	case '/upload-file':
		require __DIR__ . '/controller/send_file_controller.php';
		break;

	case '/delete-file':
		require __DIR__ . '/controller/delete_file.php';
		break;

	default:
		http_response_code(404);
		require __DIR__ . '/controller/login_user_page.php';
		break;
}
