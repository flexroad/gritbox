<?php
namespace App\Forms;
use Nette;
class Renderer extends Nette\Object implements Nette\Forms\IFormRenderer
{
	/** @var string */
	private $file;


	public function __construct($file)
	{
		$this->file = $file;
	}

	public function render(Nette\Forms\Form $form, $template = NULL)
	{
		$template->getEngine()->render($this->file, ['form' => $form]);
	}
}