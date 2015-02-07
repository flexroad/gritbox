<?php

namespace App\Forms;

use App\Model\Managers\UserManager;
use Nette,
	Nette\Application\UI;


class SignUpForm extends BaseForm
{

	private $userManager;

	public function __construct(UserManager $userManager)
	{
		$this->userManager = $userManager;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new UI\Form;
		$form->addText('email', 'E-mail:')
			->setRequired('Please enter your email.');
		$form->addText('name', 'Name:')
			->setRequired('Please enter your name.');
		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addSubmit('send', 'Sign up');
		$form->onSuccess[] = array($this, 'formSucceeded');

		return $form;
	}

	public function formSucceeded($form, $values) {


		try {
			$this->userManager->add($values->email, $values->password, $values->name);
		} catch (\App\Model\Managers\DuplicateNameException $e) {
			$form->addError("Account with this email already exists");
			return;
		}

		$this->onFormSuccess($this);


	}


}


interface ISignUpFormFactory
{
	/**
	 * @return \App\Forms\SignUpForm
	 */
	function create();
}