<?php

namespace App\Forms;

use App\Model\Managers\UserManager;
use App\Model\Repositories\PasswordResetRepository;
use App\Model\Repositories\UserRepository;
use Nette,
	Nette\Application\UI\Form;
use Nette\Mail\Message;

class SendPasswordForm extends BaseForm
{
	/* @var \App\Model\Managers\UserManager */
	private $userManager;
	/* @var \App\Model\Repositories\UserRepository */
	private $userRepository;
	/* @var \App\Model\Repositories\PasswordResetRepository */
	private $passwordResetRepository;
	/** @var Nette\Mail\IMailer  */
	private $mailer;

	public function __construct(
			UserManager $userManager,
			UserRepository $userRepository,
			PasswordResetRepository $passwordResetRepository,
			Nette\Mail\IMailer $mailer
	)
	{
		$this->userManager = $userManager;
		$this->userRepository = $userRepository;
		$this->passwordResetRepository = $passwordResetRepository;
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
		$user = $this->userRepository->findOneBy([
			'email' => $values->email
		]);

		if (!$user) {
			$form->addError("User with email " . $values->email . " does not exist.");
			return;
		}

		$hash = Nette\Utils\Random::generate(16);

		$this->passwordResetRepository->replace([
			"user_id" => $user->id,
			"hash" => $hash,
			"created" => new Nette\Utils\DateTime()
		]);

		$mail = new Message;
		$mail->setFrom('info@myapp.com')
			->addTo($values->email)
			->setSubject('Reset password')
			->setBody("Hello\n\nsomeone, probably you, asked for reset password for account " . $values->email . ".
				To set new password, visit this link: \n\n "
				. $this->presenter->link("//Sign:in", ['newpasshash' => $hash]));
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