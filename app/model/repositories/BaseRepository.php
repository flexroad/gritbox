<?php

namespace App\Model\Repositories;

use Nette;

abstract class BaseRepository
{
	/** @var Nette\Database\Context */
	private $database;


	public function __construct(\Nette\Database\Context $database)
	{
		// name of the table is derrived from name of the repository class
		preg_match('#(\w+)Repository$#', get_class($this), $m);
		$this->tableName = lcfirst($m[1]);
		$this->database = $database;
	}


	/**
	 * @return \Nette\Database\Table\Selection
	 */
	protected function getTable()
	{
		return $this->database->table($this->tableName);
	}

	/**
	 * @return \Nette\Database\Table\Selection
	 */
	public function findAll()
	{
		return $this->getTable();
	}

	/**
	 * @param array
	 * @return \Nette\Database\Table\Selection
	 */
	public function findBy(array $by)
	{
		return $this->getTable()->where($by);
	}

	/**
	 * @param array
	 * @return \Nette\Database\Table\ActiveRow|FALSE
	 */
	public function findOneBy(array $by)
	{
		return $this->findBy($by)->limit(1)->fetch();
	}

	/**
	 * @param int
	 * @return \Nette\Database\Table\ActiveRow|FALSE
	 */
	public function find($id)
	{
		return $this->getTable()->wherePrimary($id)->fetch();
	}

	/**
	 * @param int
	 * @return int
	 */
	public function insert($values)
	{
		$row = $this->getTable()->insert($values);
		return $row->id;

	}

	/**
	 * @param int
	 * @return int
	 */
	public function update($id, $values)
	{
		$this->getTable()->update($values)->where([
			"id" => $id
		]);
	}


}