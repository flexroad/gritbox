<?php

namespace App\Presenters;

use App\Forms\TemplateControl;
use Nette,
	App\Forms\SignFormFactory;


/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{
	/** @var \App\Forms\ISignInFormFactory @inject */
	public $signInFormFactory;

	/** @var \App\Forms\ISignUpFormFactory @inject */
	public $signUpFormFactory;

	/** @var \App\Forms\ISendPasswordFormFactory @inject */
	public $sendPasswordFormFactory;


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->signInFormFactory->create();
		$form->onFormSuccess[] = function ($form) {
			$form->getPresenter()->redirect('Homepage:');
		};
		return $form;
	}


	/**
	 * Sign-up form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignUpForm()
	{
		$form = $this->signUpFormFactory->create();
		$form->onFormSuccess[] = function ($form) {
			$form->getPresenter()->redirect('Sign:in');
		};
		return $form;
	}

	/**
	 * Reset password form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSendPasswordForm()
	{
		$form = $this->sendPasswordFormFactory->create();
		$form->onFormSuccess[] = function ($form) {
			$form->getPresenter()->redirect('Homepage:');
		};
		return $form;
	}


	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('in');
	}

}
