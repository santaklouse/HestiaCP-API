<?php

namespace HestiaCP\Module;

use Nette\Utils\ArrayHash;
use HestiaCP\Command\Add\User as AddUser;
use HestiaCP\Command\Change\UserPassword;
use HestiaCP\Command\Change\UserConfigValue;
use HestiaCP\Command\Change\UserName;
use HestiaCP\Command\Change\UserPackage as ChangeUserPackage;
use HestiaCP\Command\Suspend\User as SuspendUser;
use HestiaCP\Command\Unsuspend\User  as UnsuspendUser;
use HestiaCP\Command\Delete\User as DeleteUser;
use HestiaCP\Command\Lists\User;
use HestiaCP\Command\Lists\Users as ListsUsers;
use HestiaCP\Command\Lists\SysUsers as ListSysUsers;
use HestiaCP\Command\Lists\UserStats as ListUserStats;
use HestiaCP\Command\Lists\UserPackage as ListUserPackage;
use HestiaCP\Command\Lists\UserPackages as ListUserPackages;
use HestiaCP\Command\Backup\Users as BackupUsers;
use HestiaCP\Command\Update\UserStats as UpdateUserStats;

class Users extends Module {

	/**
	 * This function to obtain the list of all system users.
	 * 
	 * @return array
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function list(): array {
		return $this->client->send(new ListsUsers);
	}

	/**
	 * This function for obtaining the list of system users without detailed information.
	 * 
	 * @return array
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listSysUsers(): array {
		return $this->client->send(new ListSysUsers);
	}

	/**
	 * This function to obtain user parameters.
	 * 
	 * @param string $user
	 * @return ArrayHash
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function detail(string $user): ArrayHash {
		return $this->client->send(new User($user));
	}

	/**
	 * This function changes user's password and updates RKEY value.
	 * 
	 * @param string $user
	 * @param string $password
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changePassword(string $user, string $password): bool {
		return $this->client->send(new UserPassword($user, $password));
	}

	/**
	 * This function creates new user account.
	 * 
	 * @param string 	  $user
	 * @param string 	  $password
	 * @param string 	  $email
	 * @param string|null $package
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function add(string $user, string $password, string $email, string $package = null, string $name = null): bool {
		return $this->client->send(new AddUser($user, $password, $email, $package, $name));
	}

	/**
	 * This function suspends a certain user and all his objects.
	 * 
	 * @param string $user
	 * @param bool 	 $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function suspend(string $user, bool $restart = true): bool {
		return $this->client->send(new SuspendUser($user, $restart));
	}

	/**
	 * This function unsuspends user and all his objects.
	 * 
	 * @param string $user
	 * @param bool $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function unsuspend(string $user, bool $restart = true): bool {
		return $this->client->send(new UnsuspendUser($user, $restart));
	}

	/**
	 * This function deletes a certain user and all his resources such as domains, databases, cron jobs, etc.
	 * 
	 * @param string $user
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function delete(string $user): bool {
		return $this->client->send(new DeleteUser($user));
	}

	/**
	 * This function backups all system users.
	 * 
	 * @return string
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function backup(): string {
		return $this->client->send(new BackupUsers);
	}

	/**
	 * Changes key/value for specified user.
	 * 
	 * @param string $user
	 * @param string $key
	 * @param mixed $value
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeConfigValue(string $user, string $key, mixed $value): bool {
		return $this->client->send(new UserConfigValue($user, $key, $value));
	}

	/**
	 * This function for listing user statistics.
	 * 
	 * @param string $user
	 * @return array
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listStats(string $user): array {
		return $this->client->send(new ListUserStats($user));
	}

	/**
	 * Function logs user parameters into statistics database.
	 * 
	 * @param string $user
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function updateStats(string $user): bool {
		return $this->client->send(new UpdateUserStats($user));
	}

 	/**
	 * This function for getting the list of system ip parameters.
	 * 
	 * @param string $package
	 * @return array
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listUserPackage(string $package): array {
		return $this->client->send(new ListUserPackage($package));
	}

	/**
	 * Changes key/value for specified user.
	 * 
	 * @param string $user
	 * @param string $name
	 * @param string $surname
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeUserName(string $user, string $name, string $surname = null): bool {
		return $this->client->send(new UserName($user, $name, $surname));
	}

	/**
	 * This function for obtaining the list of available hosting packages.
	 * 
	 * @return array
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listUserPackages(): array {
		return $this->client->send(new ListUserPackages);
	}

	/**
	 * This function changes user's hosting package.
	 * 
	 * @param string $user
	 * @param string $package
	 * @param bool $force
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeUserPackage(string $user, string $package, bool $force = false): bool {
		return $this->client->send(new ChangeUserPackage($user, $package, $force));
	}
}
