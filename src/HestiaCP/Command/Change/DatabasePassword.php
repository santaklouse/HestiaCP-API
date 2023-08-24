<?php

namespace HestiaCP\Command\Change;

use HestiaCP\Command\ProcessCommand;

class DatabasePassword extends ProcessCommand {

	/** @var string */
	private $user;

	/** @var string */
	private $database;

    /** @var string */
	private $password;

	public function __construct(string $user, string $database, string $password) {
		$this->user = $user;
        $this->database = $database;
		$this->password = $password;
	}

	public function getName(): string {
		return 'v-change-database-password';
	}

	public function getRequestParams(): array {
		return [
			self::ARG_1 => $this->user,
            self::ARG_1 => $this->database,
			self::ARG_2 => $this->password
		];
	}
}
