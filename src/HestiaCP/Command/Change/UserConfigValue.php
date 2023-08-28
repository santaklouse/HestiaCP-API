<?php

namespace HestiaCP\Command\Change;

use HestiaCP\Command\ProcessCommand;

class UserConfigValue extends ProcessCommand
{

	/** @var string */
	private $user;

	/** @var string */
	private $key;

	/** @var mixed */
	private $value;

	public function __construct(string $user, string $key, mixed $value)
	{
		$this->user = $user;
		$this->key = $key;
		$this->value = $value;
	}

	public function getName(): string
	{
		return 'v-change-user-config-value';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->key,
			self::ARG_3 => (is_bool($this->value) ? $this->convertBool($this->value) : $this->value)
		];
	}
}