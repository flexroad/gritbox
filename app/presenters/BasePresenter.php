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



	/**
	 * Html Head Component
	 * @return \App\Components\HtmlHead
	 */
	protected function createComponentHtmlHead()
	{
		return $this->htmlHeadComponent;
	}

}
