<?php

class Html4PhpConfig {

    private $html4PhpConfig = array();

    protected function __contruct() {
        $this->html4PhpConfig = array(
            'devleopment' => array(
                'server' => array(
                    'domainName' => 'www.domain.com',
                    'domainName2' => 'domain.com'
                ),
                'database' => array(
                    'dbHost' => 'localhost',
                    'dbName' => 'database_name',
                    'dbUser' => 'username_database',
                    'dbPass' => ''
                )
                ,
                'email' => array(),
            ))
        ;
    }

    public function getConfig($environment, $class, $item) {
        if (isset($this->html4PhpConfig[$environment]) &&
                isset($this->html4PhpConfig[$environment][$class]) &&
                isset($this->html4PhpConfig[$environment][$class][$item])
        ){
            return $this->html4PhpConfig[$environment][$class][$item];
        }
    }

}
