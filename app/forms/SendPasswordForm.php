<?php

namespace App\Forms;

use App\Model\Managers\UserManager;
use Nette,
	Nette\Application\UI\Form;
use Nette\Mail\Message;

class SendPasswordForm extends BaseForm
{
	/* @var \App\Model\Managers\UserManager */
	private $userManager;
	/** @var Nette\Mail\IMailer  */
	private $mailer;

	public function __construct(UserManager $userManager, Nette\Mail\IMailer $mailer)
	{
		$this->userManager = $userManager;
		$this->mailer = $mailer;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form;
		$form->addText('email', 'Email:')
			->setRequired('Please enter your email.');

		$form->addSubmit('send', 'Send new password request');

		$form->onSuccess[] = array($this, 'formSucceeded');

		$form->onSuccess[] = array($this, 'formSucceeded');

		return $form;
	}


	public function formSucceeded($form, $values)
	{
		$user = $this->userManager->getByEmail($values->email);

		if (!$user) {
			$form->addError("User with email " . $values->email . " does not exist.");
			return;
		}

		$appUniqueHash = $this->presenter->context->parameters['appUniqueHash'];
		$pwdhash = Nette\Security\Passwords::hash($appUniqueHash, ['salt' => $user->public_hash]);

		$mail = new Message;
		$mail->setFrom('info@myapp.com')
			->addTo($values->email)
			->setSubject('Reset password')
			->setBody("Hello\n\nsomeone, probably you, asked for reset a password for account " . $values->email . ".
				To set new password, visit this link: \n\n "
				. $this->presenter->link("Sign:password", ['userhash' => $user->public_hash, 'pwdhash' => $pwdhash]));
		$this->mailer->send($mail);

		$this->onFormSuccess($this);

	}

}

interface ISendPasswordFormFactory
{
	/**
	 * @return \App\Forms\SendPasswordForm
	 */
	function create();
}