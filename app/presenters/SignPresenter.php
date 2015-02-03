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
	/** @var \App\Forms\SignInFormFactory @inject */
	public $signInFormFactory;

	/** @var \App\Forms\SignUpFormFactory @inject */
	public $signUpFormFactory;


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->signInFormFactory->create(function ($form) {
			$form->getPresenter()->redirect('Homepage:');
		});
		return new TemplateControl($form, __DIR__ . '/../forms/templates/SignInForm.latte');
	}


	/**
	 * Sign-up form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignUpForm()
	{
		$form = $this->signUpFormFactory->create(function ($form) {
			$form->getPresenter()->redirect('Sign:in');
		});
		return new TemplateControl($form, __DIR__ . '/../forms/templates/SignUpForm.latte');
	}


	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('in');
	}

}
