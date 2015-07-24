<?php

namespace App\Presenters;

use App\Components\HtmlHead;
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

	/** @var \App\Components\HtmlHead @inject */
	public $htmlHeadComponent;

	protected function beforeRender()
	{
	}

	/*
	 * ====== Signals ======
	 */

	public function handleLogOut()
	{
		$this->user->logout();
		$this->redirect(":Front:Sign:in");
	}


	protected function mustBeLoggedIn()
	{
		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect(':Front:Sign:in');
		}
	}
	protected function mustBeLoggedOut()
	{
		if ($this->getUser()->isLoggedIn()) {
			$this->redirect(':Admin:Homepage:default');
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

		$this->redirect(':Admin:Homepage:default');
	}

	/**
	 * Html Head Component
	 * @return \App\Components\HtmlHead
	 */
	protected function createComponentHtmlHead()
	{
		return $this->htmlHeadComponent;
	}

}
