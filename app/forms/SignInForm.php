<?php

namespace App\Forms;

use Nette,
	Nette\Application\UI\Form,
	Nette\Security\User;


class SignInForm extends BaseForm
{
	/** @var User */
	private $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form;
		$form->addText('email', 'Email:')
			->setRequired('Please enter your email.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addSubmit('send', 'Sign in');

		$form->onSuccess[] = array($this, 'formSucceeded');


		$form->onSuccess[] = array($this, 'formSucceeded');

		return $form;
	}


	public function formSucceeded($form, $values)
	{
		$this->user->setExpiration('14 days', FALSE);

		try {
			$this->user->login($values->email, $values->password);
		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
			return;
		}

		$this->onFormSuccess($this);
	}


}

interface ISignInFormFactory
{
	/**
	 * @return \App\Forms\SignInForm
	 */
	function create();
}
