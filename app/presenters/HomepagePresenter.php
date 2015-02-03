<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
	protected function startup()
	{
		parent::startup();
		$this->mustBeLoggedIn();
	}

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}



}
