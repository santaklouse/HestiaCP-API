<?php

namespace HestiaCP\Module;

use HestiaCP\Client;
use Nette\Utils\ArrayHash;

use HestiaCP\Command\Add\Database as AddDatabase;
use HestiaCP\Command\Delete\Database as DeleteDatabase;
use HestiaCP\Command\Delete\Databases as DeleteDatabases;
use HestiaCP\Command\Lists\Database as ListDatabase;
use HestiaCP\Command\Lists\Databases as ListDatabases;
use HestiaCP\Command\Change\DatabasePassword;

class Databases extends Module {

    /** @var string */
	private $user;

    public function __construct(Client $client, string $user) {
		parent::__construct($client);
		$this->user = $user;
	}

    /**
     * This function is used for creating a new database.
     * 
     * @param string    $database
     * @param string    $dbuser
     * @param string    $dbpass
     * @param string    $type
     * @return bool
     * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
     */
    public function add(string $database, string $dbuser, string $dbpass, string $type = 'mysql'): bool {
        return $this->client->send(new AddDatabase($this->user, $database, $dbuser, $dbpass, $type));
    }

    /**
     * This function is used for delete a specified database.
     * 
     * @param string    $database
     * @return bool
     * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
     */
    public function delete(string $database): bool {
        return $this->client->send(new DeleteDatabase($this->user, $database));
    }

    /**
     * This function deletes all user databases.
     * 
     * @return bool
     * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
     */
    public function deleteDatabases(): bool {
        return $this->client->send(new DeleteDatabases($this->user));
    }

    /**
     * This function for obtaining of all database's parameters.
     * 
     * @param string    $database
     * @return ArrayHash
     * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
     */
    public function listDatabase(string $database): ArrayHash {
        return $this->client->send(new ListDatabase($this->user, $database));
    }

    /**
     * This function for obtaining the list of all user's databases.
     * 
     * @param string    $database
     * @return array
     * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
     */
    public function listDatabases(): array {
        return $this->client->send(new ListDatabases($this->user));
    }

    /**
     * This function for changing database user password to a database. It uses the full name of database as argument.
     * 
     * @param string    $database
     * @param string    $password
     * @return bool
     * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
     */
    public function changePassword(string $database, string $password): bool {
        return $this->client->send(new DatabasePassword($this->user, $database, $password));
    }
}