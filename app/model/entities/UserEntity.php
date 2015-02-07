<?php

namespace App\Model\Entities;


class UserEntity extends BaseEntity
{
	/** @var int */
	public $id;

	/** @var string */
	public $name;

	/** @var string */
	public $email;

	/** @var string */
	public $role;

	/** @var string */
	public $public_hash;

}