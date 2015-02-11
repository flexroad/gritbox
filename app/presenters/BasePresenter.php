<?php

namespace App\Presenters;

use Nette,
	App\Model;
use Nette\Application\UI\Form;
use Tracy\Debugger;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var Nette\Mail\IMailer @inject */
	public $mailer;

	/** @var \App\Model\Repositories\PasswordResetRepository @inject */
	public $passwordResetRepository;

	/** @var \App\Model\Managers\UserManager @inject */
	public $userManager;

	protected function beforeRender()
	{
		$this->template->parameters = $this->context->parameters;
	}


	protected function mustBeLoggedIn()
	{
		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect('Sign:in');
		}
	}

	/*
	 * ===== FORMS ======
	 */

	public function createComponentSignInForm()
	{
		$form = new Form;
		$form->addText('email', 'Email:')
			->setRequired('Please enter your email.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		if ($this->passwordResetRow) {
			$form->addSubmit('send', 'Change password and Sign in');
			$form['email']
				->setValue($this->passwordResetRow->user->email)
				->setAttribute('readonly', TRUE);
		} else {
			$form->addSubmit('send', 'Sign in');
		}

		$form->onSuccess[] = array($this, 'signInFormSucceeded');



		return $form;
	}


	public function signInFormSucceeded($form, $values)
	{
		if ($this->passwordResetRow) {
			$this->userManager->changePassword($this->passwordResetRow->user->id, $values->password);
			$this->passwordResetRepository->delete($this->passwordResetRow->id);
		}



		$this->user->setExpiration('14 days', FALSE);

		try {
			$this->user->login($values->email, $values->password);
		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
			return;
		}

		$this->redirect('Homepage:');
	}


}
