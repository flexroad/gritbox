<?php

namespace App\Forms;

use App\Model\Managers\UserManager;
use Nette,
	Nette\Application\UI;


class SignUpFormFactory extends UI\Control
{

	private $userManager;

	public function __construct(UserManager $userManager)
	{
		$this->userManager = $userManager;
	}

	/**
	 * @return Form
	 */
	public function create($onSuccess = NULL)
	{
		$form = new UI\Form;
		$form->addText('email', 'E-mail:');
		$form->addText('name', 'Name:');
		$form->addPassword('password', 'Password:');

		$form->addSubmit('send', 'Sign up');

		$form->setRenderer(new \App\Forms\Renderer(__DIR__ . '/templates/SignUpForm.latte'));

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

	}


}
