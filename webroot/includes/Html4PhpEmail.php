<?php
include_once('Html4PhpDebug.php');
/**
 * Html4PhpEmail Depends on PHPMailer located at https://github.com/Synchro/PHPMailer. 
 * Many variables are contained in this class, be sure to set these for your situation.
 * @version 2015-01-12
 * @category PHP Framework
 * @package HTML4PHP
 * @copyright (c) microuser 1014, macro_user@outlook.com
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT OR GPL
 * <pre>
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions: The above copyright notice, this permission notice, and the public RSA key shall be included in all copies or substantial portions of the Software. THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
-----BEGIN RSA PUBLIC KEY----- ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDfpROYHVyYHe2yok8Ut5OEmNzNriV9QGdzzPm1vFJSf8Wp9iBY74xf5oYdMmUOOfLlZfcrXP6Dc3VXOlTU7P46t14s9CcoGR6As2EamV7q9sAh4Nkr6xZb4kNdy9Bd4SxY/I3kxEbTpbpPq2T5B68xJWVjf83SQI43eyjO2Hv3iA8iEyifeyAGNVX46X3uuCsBftXF5Ng1GCCp6fMeCXeY0p3qmOg7m6SMGAXY97hKakNHPN2+vDP2fCOfefFmZihP/0mQNNLu1VNfI3MKonyfiHI4k1WAbFP2ozWSGmzv3dhej3wguYmRYKsgkK3ay5QoZQSLDHnZXtkuO9rJbAuz -----END RSA PUBLIC KEY-----
 * </pre>
 */
class Html4PhpEmail {

    private $smtpDebug;
    private $smtpHost;
    private $smtpPort;
    private $smtpAuth;
    private $smtpUsername;
    private $smtpPassword;
    private $fromEmail;
    private $fromName;
    private $replyToEmail;
    private $replyToName;

    /**
     * Html4PhpEmail uses PHPMailer with default values given by Html4PhpConfig.
     * It accepts a parameter which allows you to override values from the default configs,
     * while still allowing default connection info..
     * Example:
     * <pre>
     * $e = new Html4PhpEmail(array(
     *  'fromEmail'=>'user@domain.com',
     *  'fromName'=>'Username from Domain.com',
     *  'replyToEmail'=>user@domain.com',
     *  'replyToName'=>'Username from Domain.com');
     * <pre>
     * @param Array $emailConfigs
     * 
     */
    private function __construct($emailConfigs = array()) {

        $configs = new Html4PhpConfig();
        foreach($emailConfigs as $itemName=>$item){
            $configs['email'][$itemName] = $item;
        }

        $this->smtpDebug = $configs->getConfig('email', 'smtpDebug');
        $this->smtpHost = $configs->getConfig('email', 'smtpHost');
        $this->smtpPort = $configs->getConfig('email', 'smtpPort');
        $this->smtpAuth = $configs->getConfig('email', 'smtpAuth');
        $this->smtpUsername = $configs->getConfig('email', 'smtpUsername');
        $this->smtpPassword = $configs->getConfig('email', 'smtpPassword');
        $this->fromEmail = $configs->getConfig('email', 'fromEmail');
        $this->fromName = $configs->getConfig('email', 'fromName');
        $this->replyToEmail = $configs->getConfig('email', 'replyToEmail');
        $this->replyToName = $configs->getConfig('email', 'replyToName');
    }

    public function setSmtpDebug($smtpDebug) {
        $this->smtpDebug = $smtpDebug;
    }

    public function setSmtpHost($smtpHost) {
        $this->smtpHost = $smtpHost;
    }

    public function setSmtpPort($smtpPort) {
        $this->smtpPort = $smtpPort;
    }

    public function setSmtpAuth($smtpAuth) {
        $this->smtpAuth = $smtpAuth;
    }

    public function setSmtpUsername($smtpUsername) {
        $this->smtpUsername = $smtpUsername;
    }

    public function setSmtpPassword($smtpPassword) {
        $this->smtpPassword = $smtpPassword;
    }

    public function setFromEmail($fromEmail) {
        $this->fromEmail = $fromEmail;
    }

    public function setFromName($fromName) {
        $this->fromName = $fromName;
    }

    public function setReplyToEmail($replyToEmail) {
        $this->replyToEmail = $replyToEmail;
    }

    public function setReplyToName($replyToName) {
        $this->replyToName = $replyToName;
    }

    public function sendEmail($toName, $toEmail, $subject, $messageHtml, $attachmentPaths = array()) {

        //Downlaod from https://github.com/Synchro/PHPMailer
        //Appears to be MIT License
        require $_SERVER['DOCUMENT_ROOT'] . 'resources/phpMailer/PHPMailerAutoload.php';

        //date_default_timezone_set('Etc/UTC');
//Create a new PHPMailer instance
        $mail = new PHPMailer();
//Tell PHPMailer to use SMTP
        $mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = $this->smtpDebug;
//Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';
//Set the hostname of the mail server
        $mail->Host = $this->smtpHost; //localhost
//Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = $this->smtpPort; //was 25
//Whether to use SMTP authentication
        $mail->SMTPAuth = $this->smtpAuth;
//Username to use for SMTP authentication
        $mail->Username = $this->smtpUsername;
//Password to use for SMTP authentication
        $mail->Password = $this->smtpPassword;
//Set who the message is to be sent from
        $mail->setFrom($this->fromEmail, $this->fromName);
//Set an alternative reply-to address
        $mail->addReplyTo($this->replyToEmail, $this->replyToName);
//Set who the message is to be sent to
        $mail->addAddress($toEmail, $toName);
//Set the subject line
        $mail->Subject = $subject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
        $mail->msgHTML($messageHtml);
//Replace the plain text body with one created manually
        //$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
        if(is_array($attachmentPaths)){
            foreach($attachmentPaths as $name=>$attachemntPath){
                $mail->addAttachment($attachemntPath,$name);
            }
        }elseif(is_string($attachmentPaths)){
            $mail->addAttachement($attachementPath);
        }
        
//send the message, check for errors
        if (!$mail->send()) {
            return "Mailer Error: " . $mail->ErrorInfo;
        } else {
            return "Email sent! Check the inbox of: " . $toEmail;
        }
    }

}
