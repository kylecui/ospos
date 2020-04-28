<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Email library
 *
 * Library with utilities to configure and send emails
 */

class Email_lib
{
	private $CI;

  	public function __construct()
	{
		$this->CI =& get_instance();

		$this->CI->load->library('email');

		$config = array(
			'mailtype' => 'html',
			'useragent' => 'OSPOS',
			'validate' => TRUE,
			'protocol' => $this->CI->config->item('protocol'),
			'mailpath' => $this->CI->config->item('mailpath'),
			'smtp_host' => $this->CI->config->item('smtp_host'),
			'smtp_user' => $this->CI->config->item('smtp_user'),
			'smtp_pass' => $this->CI->encryption->decrypt($this->CI->config->item('smtp_pass')),
			'smtp_port' => $this->CI->config->item('smtp_port'),
			'smtp_timeout' => $this->CI->config->item('smtp_timeout'),
			'smtp_crypto' => $this->CI->config->item('smtp_crypto')
		);

		$this->CI->email->initialize($config);
	}

	/**
	 * Email sending function
	 * Example of use: $response = sendEmail('john@doe.com', 'Hello', 'This is a message', $filename);
	 */
	public function sendEmail($to, $subject, $message, $attachment = NULL)
	{
		require 'class.smtp.php';
		require 'class.phpmailer.php';
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.exmail.qq.com";
		$mail->Port = 465;
		$mail->SMTPSecure = 'ssl';
        $mail->addAddress($to);
		if(!empty($attachment))
		{
			$mail->addStringAttachment($attachment);
		}
		$mail->Username = "service@cxzlife.cn";
		$mail->Password = "cici0405";
		$mail->setFrom('no-reply-service@cxzlife.cn', 'CiCi Jewelry');
		$mail->addReplyTo('no-reply-service@cxzlife.cn', 'CiCi Jewelry');
        $mail->Subject = $subject;
        $mail->msgHTML($message);
        // $mail->send();
		$result = $mail->send();
		if(!$result)
		{
			error_log($email->print_debugger());
		}
		return $result;
		// $email = $this->CI->email;

		// $email->from($this->CI->config->item('email'), $this->CI->config->item('company'));
		// $email->to($to);
		// $email->subject($subject);
		// $email->message($message);
		// if(!empty($attachment))
		// {
		// 	$email->attach($attachment);
		// }

		// $result = $email->send();

		// if(!$result)
		// {
		// 	error_log($email->print_debugger());
		// }

		// return $result;
	}
}

?>
