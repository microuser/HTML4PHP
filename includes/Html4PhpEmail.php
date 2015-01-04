<?php

/**
 * Html4PhpEmail Depends on PHPMailer located at https://github.com/Synchro/PHPMailer. 
 * Many variables are contained in this class, be sure to set these for your situation.
 * @version 2015-01-04
 * @category PHP Framework
 * @copyright (c) microuser 1014, macro_user@outlook.com
 * @author microuser
 * @link https://github.com/microuser/HTML4PHP 
 * @license https://github.com/microuser/HTML4PHP/blob/master/LICENSE MIT
 */
class Html4PhpEmail {

    public function sendEmail($toName, $toEmail, $subject, $messageHtml) {

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
        $mail->SMTPDebug = $this->getConfig('email','smtpDebug');
//Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';
//Set the hostname of the mail server
        $mail->Host = $this->getConfig('email','smtpHost'); //localhost
//Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = $this->getConfig('email','smtpPort'); //was 25
//Whether to use SMTP authentication
        $mail->SMTPAuth = $this->getConfig('email','smtpAuth');
//Username to use for SMTP authentication
        $mail->Username = $this->getConfig('email','smtpUsername');
//Password to use for SMTP authentication
        $mail->Password = $this->getConfig('email','smtpPassword');
//Set who the message is to be sent from
        $mail->setFrom($this->getConfig('email','fromEmail'), $this->getConfig('email','fromName'));
//Set an alternative reply-to address
        $mail->addReplyTo($this->getConfig('email','replyToEmail'), $this->getConfig('email','replyToName'));
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
        //$mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
        if (!$mail->send()) {
            return "Mailer Error: " . $mail->ErrorInfo;
        } else {
            return "Email sent! Check the inbox of: " . $toEmail;
        }
    }

}
