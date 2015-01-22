<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/includes/Html4PhpSite.php');

$page = new Html4PhpSite("Html4Php Tests");
$page->add("This is the landing page for Tests");
echo $page->generatePage();