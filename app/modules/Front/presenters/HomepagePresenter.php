<?php

namespace App\FrontModule\Presenters;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 * @resource Front:Homepage
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}



}
