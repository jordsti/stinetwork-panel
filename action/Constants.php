<?php
//Constants
global $menu;
global $domains;

$menu = array(
	'Home' => 'index.php',
	'Email' => 'email_form.php',
	'Panel' => 'panel.php',
	//'Hosted project(s)' => 'projects.php',
	//'About us' => 'about.php'
);

define('SENDMAIL', false);
define('EMAIL_PASS_SCHEME', 'sha256');
