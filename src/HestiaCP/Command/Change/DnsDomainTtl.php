<?php

namespace HestiaCP\Command\Change;

use HestiaCP\Command\ProcessCommand;

class DnsDomainTtl extends ProcessCommand
{

	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var int */
	private $ttl;

	/** @var bool */
	private $restart;

	public function __construct(string $user, string $domain, int $ttl, bool $restart = false)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->ttl = $ttl;
		$this->restart = $restart;
	}

	public function getName(): string
	{
		return 'v-change-dns-domain-ttl';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->ttl,
			self::ARG_4 => $this->convertBool($this->restart)
		];
	}
}