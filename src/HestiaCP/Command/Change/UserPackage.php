<?php

namespace HestiaCP\Command\Change;

use HestiaCP\Command\ProcessCommand;

class UserPackage extends ProcessCommand
{

	/** @var string */
	private $user;

	/** @var string */
	private $package;

	/** @var bool */
	private $force;

	public function __construct(string $user, string $package, bool $force)
	{
		$this->user = $user;
		$this->package = $package;
		$this->force = $force;
	}

	public function getName(): string
	{
		return 'v-change-user-package';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->package,
			self::ARG_3 => $this->convertBool($this->force)
		];
	}
}