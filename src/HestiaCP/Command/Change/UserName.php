<?php

namespace HestiaCP\Command\Change;

use HestiaCP\Command\ProcessCommand;

class UserName extends ProcessCommand
{

	/** @var string */
	private $user;

	/** @var string */
	private $name;

	/** @var mixed */
	private $surname;

	public function __construct(string $user, string $name, mixed $surname)
	{
		$this->user = $user;
		$this->name = $name;
		$this->surname = $surname;
	}

	public function getName(): string
	{
		return 'v-change-user-name';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->name,
			self::ARG_3 => $this->surname
		];
	}
}