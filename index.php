<?php
session_start();
//1.Обшие настройки
ini_set('display errors', 1);
error_reporting(E_ALL);
//todo удалить

//2.Подключаем файлы системы
define('ROOT', dirname(__FILE__));
require_once (ROOT.'/components/Autoload.php');

//3.Соидинение БД
//4.Вызываем роутер
$router=new Router();
$router->run();