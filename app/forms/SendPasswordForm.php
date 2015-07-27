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
	/** @var \App\Services\EmailService  */
	private $emailService;

	public function __construct(
			UserManager $userManager,
			UserRepository $userRepository,
			PasswordResetRepository $passwordResetRepository,
			\App\Services\EmailService $emailService
	)
	{
		$this->userManager = $userManager;
		$this->userRepository = $userRepository;
		$this->passwordResetRepository = $passwordResetRepository;
		$this->emailService = $emailService;
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

		$this->emailService->send($values->email, [
			'email' => $values->email,
			'resetUrl' => $this->presenter->link("//Sign:in", ['newpasshash' => $hash])
		], 'passwordResetRequest.latte');


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