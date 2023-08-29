<?php

namespace HestiaCP\Command\Update;

use HestiaCP\Command\ProcessCommand;

class UserStats extends ProcessCommand
{
	/** @var string */
	private $user;

	public function __construct(string $user)
	{
		$this->user = $user;
	}

	public function getName(): string
	{
		return 'v-update-user-stats';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user
		];
	}
}