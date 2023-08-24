<?php

namespace HestiaCP\Command\Add;

use HestiaCP\Command\ProcessCommand;

class DnsOnWebAlias extends ProcessCommand
{
	/** @var string */
	private $user;

	/** @var string */
	private $alias;

	/** @var string */
	private $ip;

	/** @var bool */
	private $restart;

	public function __construct(string $user, string $alias, string $ip, bool $restart = false)
	{
		$this->user = $user;
		$this->alias = $alias;
		$this->ip = $ip;
		$this->restart = $restart;
	}

	public function getName(): string
	{
		return 'v-add-dns-on-web-alias';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->alias,
			self::ARG_3 => $this->ip,
			self::ARG_4 => $this->convertBool($this->restart)
		];
	}
}