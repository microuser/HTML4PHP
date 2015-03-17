<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/ContactodexPage.php');
$page = new ContactodexPage("Contactodex View Details");
$page->addContactEdit();
echo $page;
        