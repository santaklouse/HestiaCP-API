<?php

namespace HestiaCP\Command\Get;

use HestiaCP\Command\ProcessCommand;

class DnsDomainValue extends ProcessCommand
{
	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var string */
	private $key;

	public function __construct(string $user, string $domain, string $key)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->key = $key;
	}

	public function getName(): string
	{
		return 'v-get-dns-domain-value';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->key
		];
	}
}