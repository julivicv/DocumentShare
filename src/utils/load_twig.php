<?php
# twig_carregar.php
require('../vendor/autoload.php');

$loader = new \Twig\Loader\FilesystemLoader('./view');


$twig = new \Twig\Environment($loader);