<?php

namespace HestiaCP\Module;

use Nette\Utils\ArrayHash;
use HestiaCP\Client;

use HestiaCP\Command\Backup\User as BackupUser;
use HestiaCP\Command\Delete\UserBackup as DeleteUserBackup;
use HestiaCP\Command\Delete\UserBackupExclusions as DeleteUserBackupExclusions;
use HestiaCP\Command\Lists\UserBackup as ListsUserBackup;
use HestiaCP\Command\Lists\UserBackups;
use HestiaCP\Command\Lists\UserBackupExclusions as ListsUserBackupExclusions;

class Backups extends Module {

    /** @var string */
	private $user;

    public function __construct(Client $client, string $user) {
		parent::__construct($client);
		$this->user = $user;
	}

    /**
     * This call is used for backing up user with all its domains and databases.
     * 
     * @param bool  $notify
     * @return string
     * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
     */
    public function backup(bool $notify = true): string {
        return $this->client->send(new BackupUser($this->user, $notify));
    }

    /**
     * This function deletes user backup.
     * 
     * @param string    $backup
     * @return bool
     * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
     */
    public function delete(string $backup): bool {
        return $this->client->send(new DeleteUserBackup($this->user, $backup));
    }

    /**
     * This function for deleting backup exclusion
     * 
     * @return bool
     * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
     */
    public function deleteExclusions(): bool {
        return $this->client->send(new DeleteUserBackupExclusions($this->user));
    }

    /**
     * This function for obtaining the list of available user backups.
     * 
     * @return array
     * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
     */
    public function listBackups(): array {
        return $this->client->send(new UserBackups($this->user));
    }

    /**
     * This function of obtaining the list of backup parameters.
     * 
     * @param string    $backup
     * @return ArrayHash
     * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
     */
    public function listBackup(string $backup): ArrayHash {
        return $this->client->send(new ListsUserBackup($this->user, $backup));
    }

    /**
     * This function for obtaining the backup exclusion list
     * 
     * @return array
     * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
     */
    public function listBackupExclusions(): array {
        return $this->client->send(new ListsUserBackupExclusions($this->user));
    }
}