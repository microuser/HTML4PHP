<?php
/*
 * @version 2015-01-04
 * @category PHP Framework
 * @copyright (c) microuser 1014, macro_user@outlook.com
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT
 */
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/SamplePage.php');
$page = new SamplePage();
echo $page->generateSamplePage();