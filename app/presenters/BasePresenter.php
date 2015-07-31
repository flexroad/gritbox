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

	/** @var \App\Components\HtmlAssets @inject */
	public $htmlAssetsComponent;


	/**
	 * Check authorization
	 * @return void
	 */
	public function checkRequirements($element)
	{
		if ($element instanceof Nette\Reflection\Method) {
			/**
			 * Check permissions for Action/handle methods
			 *
			 *  - Do not that (rely on presenter authorization)
			 */
			return;
		} else {
			$resource = $element->getAnnotation('resource');
		}
		if (!$this->user->isAllowed($resource)) {
			if (!$this->user->isLoggedIn()) {
				$this->redirect(':Front:Sign:in', ['backlink' => $this->storeRequest()]);
			} else {
				throw new Nette\Application\ForbiddenRequestException;
			}
		}

		if ($this->user->isLoggedIn() && $resource == 'Front:Sign') {
			$this->redirect(':Admin:Homepage:default');
		}
	}


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

	/**
	 * Html Head Component
	 * @return \App\Components\HtmlHead
	 */
	protected function createComponentHtmlAssets()
	{
		return $this->htmlAssetsComponent;
	}

}
