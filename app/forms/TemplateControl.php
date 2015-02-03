<?php

namespace App\Forms;

use Nette;

class TemplateControl extends Nette\Application\UI\Control
{
	/** @var string */
	private $file;

	public function __construct($form, $file)
	{
		$this['form'] = $form;
		$this->file = $file;
	}

	public function render()
	{
		$this->template->render($this->file, ['form' => 'form']);
	}
}