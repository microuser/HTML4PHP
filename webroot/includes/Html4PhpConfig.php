<?php
include_once 'Html4PhpDebug.php';
class Html4PhpConfig extends Html4PhpDebug{

    private $configs = array();
/**
 * Contains Configuration data for HTML4PHP Framework
 */
    public function __construct($title) {
         //--------------------------------------------------------------------
        //  Development Config Details
        //====================================================================
        $developmentConfig = array(
            'server' => array(
                'domainName' => 'html4php.dev',
                'domainName2' => 'www.html4php.dev',
                'domainIp' => '192.168.56.156'
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
        );
        //--------------------------------------------------------------------
        //  Production Config Details
        //====================================================================
        $productionConfig = array(
            'server' => array(
                'domainName' => 'www.domain.com',
                'domainName2' => 'domain.com',
                'domainIp' => '0.0.0.0'
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
        );

        
        $this->autoSetConfig(array(
            'production' => $productionConfig,
            'development' => $developmentConfig
        ));
        unset($productionConfig);
        unset($developmentConfig);
    }

    /**
     * Detects the production/devlopment environment and assigns the correct one for use by getConfig
     * @param type $configs
     * @param type $fallbackToDev
     */
    private function autoSetConfig($configs, $fallbackToDev = true) {
        echo "autoSetConfig";
        if ($_SERVER['SERVER_NAME'] == $configs['production']['server']['domainName'] ||
                $_SERVER['SERVER_NAME'] == $configs['production']['server']['domainName2'] ||
                $_SERVER['SERVER_NAME'] == $configs['production']['server']['domainIp']) {
            $this->configs = $configs['production'];
            $this->configs['config']['environment'] = 'production';
        } elseif ($_SERVER['SERVER_NAME'] == $configs['development']['server']['domainName'] ||
                $_SERVER['SERVER_NAME'] == $configs['development']['server']['domainName2'] ||
                $_SERVER['SERVER_NAME'] == $configs['development']['server']['domainIp']) {
            $this->configs = $configs['development'];
            $this->configs['config']['environment'] = 'development';
        } elseif ($fallbackToDev === true) {
            //As a failsafe, fallback to devlopment config details
            $this->configs = $configs['development'];
            $this->configs['config']['environment'] = 'development';
        }
    }


    /**
     * Get value of item in Html4PhpConfig config file.
     * @param type $class
     * @param type $item
     * @return type
     */
    public function getConfig($class, $item) {
        if (isset($this->configs[$class]) && isset($this->configs[$class][$item])) {
            
            return $this->configs[$class][$item];
            
        }
        return "<pre>ERROR on class=$class, item=$item:".print_r($this->configs,1);
    }

}
