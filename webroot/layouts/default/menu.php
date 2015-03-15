<?php

/*
 * @version 2015-01-04
 * @category PHP Framework
 * @copyright (c) microuser 1014, macro_user@outlook.com
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT
 */

$this->menu = array(
    'Home' => array(
        '/index.php',
        array(
        //'subitem1.1' => 'link1.1.html',
        //'subitem1.2' => 'link1.2.html',
        //'subitem1.3' => 'link1.3.html',
        )
        
    ),
    'Sample' => array(
        '/sample/index.php',
        array(
            'Sample' => '/sample/index.php',
            'One' => '/sample/one.php',
            'Two' => '/sample/two.php',
            'Three' => '/sample/three.php',
        )
    ),
    'Tests' => array(
        '/tests/index.php',
        array(
            'Config' => '/tests/config.php',
            'Database' => '/tests/database.php',
            'Form' => '/tests/form.php',
            'Page' => '/tests/page.php',
            'Site' => '/tests/site.php',
            'User' => '/tests/user.php',
            'Validator' => '/tests/validator.php',
        )
    ),
    'jQueryUI' => array(
        '/jqueryui/index.php',
        array(
            'Tabs' => '/jqueryui/tabs.php',
        //'Form' => '/tests/form.php',
        //'Page' => '/tests/page.php',
        //'Site' => '/tests/site.php',
        //'Validator' => '/tests/validator.php',
        )
    ),
    'Contactodex' => array(
        '/contactodex/index.php',
        array('Contactodex' => '/contactodex/index.php')
    )
);



