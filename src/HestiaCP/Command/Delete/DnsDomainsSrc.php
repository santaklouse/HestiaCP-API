<?php

namespace HestiaCP\Command\Delete;

use HestiaCP\Command\ProcessCommand;

class DnsDomainsSrc extends ProcessCommand
{
	/** @var string */
	private $user;

	/** @var string */
	private $src;

	/** @var bool */
	private $restart;

	public function __construct(string $user, string $src, bool $restart = false)
	{
		$this->user = $user;
		$this->src = $src;
		$this->restart = $restart;
	}

	public function getName(): string
	{
		return 'v-delete-dns-domains-src';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->src,
			self::ARG_3 => $this->convertBool($this->restart)
		];
	}
}