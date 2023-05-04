<?php
require('../utils/load_twig.php');


$view = $twig->load('login.html');

echo $view->render(['title' => 'Login']);