<?php

define('SHOW_ERRORS', true);

//Password
define ("SALTHEADER","PLOP23B453J");
define ("SALTTRAILER","FDSF9434VH");

define('DB_HOST', $_SERVER['SERVER_NAME'] == 'localhost' ? 'yourdomain.com' : 'localhost');
define('DB_NAME', 'DB_NAME');
define('DB_USER', 'DB_USER');
define('DB_PASS', 'DB_PASS');

//define('PATH_DIR', pathinfo($_SERVER['PHP_SELF'])['dirname']);
define('PATH_DIR', (pathinfo($_SERVER['PHP_SELF'])['dirname'] != '/' ? pathinfo($_SERVER['PHP_SELF'])['dirname'] : null ));
define('PATH_URL', '//' . $_SERVER['HTTP_HOST'] . PATH_DIR);
