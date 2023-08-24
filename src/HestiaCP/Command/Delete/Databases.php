<?php

namespace HestiaCP\Command\Delete;

use HestiaCP\Command\ProcessCommand;

class Databases extends ProcessCommand {

	/** @var string */
	private $user;

	public function __construct(string $user) {
		$this->user = $user;
	}

	public function getName(): string {
		return 'v-delete-databases';
	}

	public function getRequestParams(): array {
		return [
			self::ARG_1 => $this->user
		];
	}
}
