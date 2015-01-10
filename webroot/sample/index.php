<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/classes/SamplePage.php');
$page = new SamplePage();
echo $page->generateSamplePage();

