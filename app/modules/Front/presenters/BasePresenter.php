<?php

namespace App\FrontModule\Presenters;

use Nette,
	App\Model;
use Nette\Application\UI\Form;

/**
 * Front module Base presenter.
 */
class BasePresenter extends \App\Presenters\BasePresenter
{


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

}
