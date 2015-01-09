<?php
include_once 'Html4PhpDebug.php';

/** 
 * @version 2015-01-04
 * @category PHP Framework
 * @package HTML4PHP
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT OR GPL
 * @copyright (c) microuser 2014, macro_user@outlook.com
 * <pre>
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions: The above copyright notice, this permission notice, and the public RSA key shall be included in all copies or substantial portions of the Software. THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
-----BEGIN RSA PUBLIC KEY----- ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDfpROYHVyYHe2yok8Ut5OEmNzNriV9QGdzzPm1vFJSf8Wp9iBY74xf5oYdMmUOOfLlZfcrXP6Dc3VXOlTU7P46t14s9CcoGR6As2EamV7q9sAh4Nkr6xZb4kNdy9Bd4SxY/I3kxEbTpbpPq2T5B68xJWVjf83SQI43eyjO2Hv3iA8iEyifeyAGNVX46X3uuCsBftXF5Ng1GCCp6fMeCXeY0p3qmOg7m6SMGAXY97hKakNHPN2+vDP2fCOfefFmZihP/0mQNNLu1VNfI3MKonyfiHI4k1WAbFP2ozWSGmzv3dhej3wguYmRYKsgkK3ay5QoZQSLDHnZXtkuO9rJbAuz -----END RSA PUBLIC KEY-----
 * </pre>
 * </pre> */
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
                'domainIp' => '192.168.56.156',
                'documentRoot' => $_SERVER['DOCUMENT_ROOT'].'/',
                'serverName' => $_SERVER['SERVER_NAME'],
                'relativeUrl' => '/',
                'absoluteUrl' => 'http://'.$_SERVER['SERVER_NAME'].'/',
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
                'absoluteUrl' => 'http://'.$_SERVER['SERVER_NAME'].'/',
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
