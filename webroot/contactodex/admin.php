<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/ContactodexPage.php');
$page = new ContactodexPage("Contactodex");
$page->addAdminScreen();
echo $page;
