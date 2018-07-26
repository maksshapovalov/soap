<?php
require_once __DIR__ . '/vendor/autoload.php';
include ('config.php');
include ('libs/Controller.php');
include ('libs/View.php');
include ('libs/Model.php');



try
{
  $obj = new Controller();
}
catch(Exception $e)
{
  echo $e->getMessage();
}






