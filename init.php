<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header("Content-Type:Application/Json");

require_once './core/app.php';
require_once './core/controller.php';
require_once './core/imodel.php';
require_once './core/model.php';
require_once './config/database.php';

define("ROOT_DIR","./");
define("CDIR",ROOT_DIR."controllers/");
define("MDIR",ROOT_DIR."models/");


?>