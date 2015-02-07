<?php

namespace App\Forms;

use App\Model\Managers\UserManager;
use Nette,
	Nette\Application\UI;


class BaseForm extends UI\Control
{
	public $onFormSuccess;

	public function render()
	{
		$this->template->presenter = $this->presenter;
		$this->template->render(__DIR__ . '/templates/' . $this->getReflection()->getShortName() . '.latte');
	}

}

