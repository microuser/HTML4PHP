<?php

include_once('SamplePage.php');
$page = new SamplePage();
$page->addDebug("hello");
$page->add($page->getDebugHtml());
$page->addDiv("asdfasdf");
echo $page->generateSamplePage();
