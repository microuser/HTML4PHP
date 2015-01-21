<?php

//--------------------------------------------------------------------
//  Development Config Details
//====================================================================
$developmentConfig = array(
    'server' => array(
        'domainName' => 'html4php.dev',
        'domainName2' => 'www.html4php.dev',
        'domainIp' => '192.168.56.156',
        'documentRoot' => $_SERVER['DOCUMENT_ROOT'] . '/',
        'serverName' => $_SERVER['SERVER_NAME'],
        'relativeUrl' => '/',
        'absoluteUrl' => 'http://' . $_SERVER['SERVER_NAME'] . '/',
    ),
    'database' => array(
        'dbHost' => 'localhost',
        'dbName' => 'dbname',
        'dbUser' => 'dbuser',
        'dbPass' => 'password'
    )
    ,
    'email' => array(
        'smtpDebug' => 2,
        'smtpHost' => 'localhost',
        'smtpPort' => 26,
        'smtpAuth' => true,
        'smtpUsername' => 'webmaster@domain.com',
        'smtpPassword' => 'password',
        'fromEmail' => 'webmaster@domain.com',
        'fromName' => "The Webmaster of domain.com",
        'replyToEmail' => 'webmaster@domain.com',
        'replyToName' => 'The Webmaster domain.com',
    ),
    'site' => array(
        'layout' => 'default',
    ),
    'resources' => array(
        'fullcalendar' => 1,
        'jquery' => 1,
        'jquery-form-validator' => 0,
        'jqueryui' => 1,
        'tablesorter' => 1,
    ),
    'environment' => array(
        'debugLevel' => 0
    ),
);
//--------------------------------------------------------------------
//  Staging Config Details
//====================================================================

$stagingConfig = array(
    'server' => array(
        'domainName' => 'html4php.stage',
        'domainName2' => 'www.html4php.stage',
        'domainIp' => '192.168.56.156',
        'documentRoot' => $_SERVER['DOCUMENT_ROOT'] . '/',
        'serverName' => $_SERVER['SERVER_NAME'],
        'relativeUrl' => '/',
        'absoluteUrl' => 'http://' . $_SERVER['SERVER_NAME'] . '/',
    ),
    'database' => array(
        'dbHost' => 'localhost',
        'dbName' => 'dbname',
        'dbUser' => 'dbuser',
        'dbPass' => 'password'
    )
    ,
    'email' => array(
        'smtpDebug' => 2,
        'smtpHost' => 'localhost',
        'smtpPort' => 26,
        'smtpAuth' => true,
        'smtpUsername' => 'webmaster@domain.com',
        'smtpPassword' => 'password',
        'fromEmail' => 'webmaster@domain.com',
        'fromName' => "The Webmaster of domain.com",
        'replyToEmail' => 'webmaster@domain.com',
        'replyToName' => 'The Webmaster domain.com',
    ),
    'site' => array(
        'layout' => 'default',
    ),
    'resources' => array(
        'fullcalendar' => 1,
        'jquery' => 1,
        'jquery-form-validator' => 0,
        'jqueryui' => 1,
        'tablesorter' => 1,
    ),
    'environment' => array(
        'debugLevel' => 0
    ),
);

//--------------------------------------------------------------------
//  Production Config Details
//====================================================================
$productionConfig = array(
    'server' => array(
        'domainName' => 'www.domain.com',
        'domainName2' => 'domain.com',
        'domainIp' => '0.0.0.0',
        'relativeUrl' => '/',
        'absoluteUrl' => 'http://' . $_SERVER['SERVER_NAME'] . '/',
    ),
    'database' => array(
        'dbHost' => 'localhost',
        'dbName' => 'database_name',
        'dbUser' => 'username_database',
        'dbPass' => 'password'
    )
    ,
    'email' => array(
        'smtpDebug' => 2,
        'smtpHost' => 'localhost',
        'smtpPort' => 26,
        'smtpAuth' => true,
        'smtpUsername' => 'webmaster@domain.com',
        'smtpPassword' => 'password',
        'fromEmail' => 'webmaster@domain.com',
        'fromName' => "The Webmaster of domain.com",
        'replyToEmail' => 'webmaster@domain.com',
        'replyToName' => 'The Webmaster domain.com',
    ),
    'site' => array(
        'layout' => 'default',
    ),
    'environment' => array(
        'debugLevel' => 0
    ),
);


