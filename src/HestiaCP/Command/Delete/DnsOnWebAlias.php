<?php

namespace HestiaCP\Command\Delete;

use HestiaCP\Command\ProcessCommand;

class DnsOnWebAlias extends ProcessCommand
{
	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var string */
	private $alias;

	/** @var bool */
	private $restart;

	public function __construct(string $user, string $domain, string $alias, bool $restart = false)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->alias = $alias;
		$this->restart = $restart;
	}

	public function getName(): string
	{
		return 'v-delete-dns-on-web-alias';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->alias,
			self::ARG_4 => $this->convertBool($this->restart)
		];
	}
}