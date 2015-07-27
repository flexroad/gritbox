<?php

namespace App\Services;


use Nette\Mail\Message;

class EmailService extends \Nette\Object
{

	private $templateDir, $archiveEmail, $fromEmail, $mailer;

	public function __construct($templateDir, $archiveEmail, $fromEmail, \Nette\Mail\IMailer $mailer)
	{
		$this->templateDir = $templateDir;
		$this->archiveEmail = $archiveEmail;
		$this->fromEmail = $fromEmail;
		$this->mailer = $mailer;
	}

	/**
	 * @param $to array|string
	 * @param $params array
	 * @param $template string
	 * @return bool|string
	 * @throws \Exception
	 */
	public function send($to, $params, $template)
	{
		$latte = new \Latte\Engine;

		$mail = new Message;
		$mail->setFrom($this->fromEmail)
			->setHtmlBody($latte->renderToString($this->templateDir . '/' . $template, $params));

		if ( ! empty($this->archiveEmail)) {
			$mail->addBcc($this->archiveEmail);
		}

		if (is_string($to)) {
			$mail->addTo($to);
		} elseif (is_array($to) && count($to) > 0) {
			$mail->addTo($to[0]);
			for ($i = 1; $i < count($to) ; $i++) {
				$mail->addCc($to[$i]);
			}
		} else {
			return "Bad 'to' parameter";
		}

		$this->mailer->send($mail);


		return true;

	}




}