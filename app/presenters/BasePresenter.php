<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	protected function beforeRender()
	{
		$this->template->parameters = $this->context->parameters;
	}


	protected function mustBeLoggedIn()
	{
		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect('Sign:in');
		}
	}

}
