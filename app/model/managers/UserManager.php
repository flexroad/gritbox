<?php

namespace App\Model\Managers;


use App\Model\Entities\UserEntity;
use Nette,
	Nette\Utils\Strings,
	Nette\Security\Passwords,
	App\Model\Repositories\UserRepository;

class UserManager extends BaseManager implements Nette\Security\IAuthenticator
{
	/**
	 * @var UserRepository
	 */
	protected $repository;

	/**
	 * @param UserRepository $repository
	 */
	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Performs an authentication.
	 * @param array $credentials
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($email, $password) = $credentials;

		$row = $this->repository->findOneBy([
			"email" => $email
		]);

		if (!$row) {
			throw new Nette\Security\AuthenticationException('The email is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $row['password'])) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		} elseif (Passwords::needsRehash($row['password'])) {
			$row->update(array(
				'password'=> Passwords::hash($password),
			));
		}

		$arr = $row->toArray();
		unset($arr['password']);
		return new Nette\Security\Identity($row['id'], $row['role'], $arr);
	}

	/**
	 * Adds new user.
	 * @param $email
	 * @param $password
	 * @param $name
	 * @throws DuplicateNameException
	 */
	public function add($email, $password, $name)
	{
		try {
			$this->repository->insert([
				"email" => $email,
				"password" => Passwords::hash($password),
				"public_hash" => Nette\Utils\Random::generate(22),
				"name" => $name,
			]);
		} catch (Nette\Database\UniqueConstraintViolationException $e) {
			throw new DuplicateNameException;
		}
	}

	public function changePassword($userId, $password)
	{
		$this->repository->update($userId, [
			"password" => Passwords::hash($password),
		]);
	}

}



class DuplicateNameException extends \Exception
{}
