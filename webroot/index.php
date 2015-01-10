<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/SamplePage.php');
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
$page = new SamplePage();


echo $page->generateSamplePage();


