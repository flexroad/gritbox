<?php

namespace App\AdminModule\Presenters;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends \App\Presenters\BasePresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}



}
