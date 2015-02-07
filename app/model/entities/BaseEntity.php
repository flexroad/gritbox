<?php

namespace App\Model\Entities;

use Nette\InvalidStateException;
use Nette\Object;

abstract class BaseEntity extends Object
{
	public function __construct($row = FALSE)
	{
		if ($row) {
			if (!isset($row->id)){
				throw new InvalidStateException('No data for Entity loaded');
			}
			foreach (get_object_vars($this) as $property => $value) {
				if (isset($row->$property)) {
					$this->$property = $row->$property;
				} else {
					throw new InvalidStateException("Missing column in database for property '$property'");
				}
			}

		}
	}
}