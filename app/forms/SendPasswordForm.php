<?php

namespace App\Forms;

use App\Model\Managers\UserManager;
use Nette,
	Nette\Application\UI\Form;


class SendPasswordForm extends BaseForm
{
	/* @var \App\Model\Managers\UserManager */
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