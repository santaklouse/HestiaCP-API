<?php

namespace HestiaCP\Command\Purge;

use HestiaCP\Command\ProcessCommand;

class NginxCache extends ProcessCommand
{
	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	public function __construct(string $user,string $domain)
	{
		$this->user = $user;
		$this->domain = $domain;
	}

	public function getName(): string
	{
		return 'v-purge-nginx-cache';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain
		];
	}
}