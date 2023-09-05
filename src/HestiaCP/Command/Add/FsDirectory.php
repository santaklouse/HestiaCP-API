<?php

namespace HestiaCP\Command\Add;

use HestiaCP\Command\ProcessCommand;

class FsDirectory extends ProcessCommand {

	/** @var string */
	private $user;

	/** @var string */
	private $path;

	public function __construct(string $user, string $path) {
		$this->user = $user;
		$this->path = $path;
	}

	public function getName(): string {
		return 'v-add-fs-directory';
	}

	public function getRequestParams(): array {
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->path
		];
	}
}