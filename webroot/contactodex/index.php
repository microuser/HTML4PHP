<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/ContactodexPage.php');
$page = new ContactodexPage("Contactodex");
$page->addDiv("A contact list with a comment history");
echo $page;
        