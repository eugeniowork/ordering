<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter PHPMailer Class
 *
 * This class enables SMTP email with PHPMailer
 *
 * @category    Libraries
 * @author      CodexWorld
 * @link        https://www.codexworld.com
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class PHPMailer_Lib
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
        // Include PHPMailer library files
        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';
        
        $mail = new PHPMailer;
        // SMTP configuration
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'acidojequerie@gmail.com';
        $mail->Password = 'lbyrevzmnkbskrgw';
        $mail->SMTPSecure = 'tsl';
        $mail->Port = 587;
        //live server 25 localhost 587
        $mail->setFrom('acidojequerie@gmail.com', APPNAME);
        $mail->addReplyTo('acidojequerie@gmail.com', APPNAME);

        return $mail;
    }
}