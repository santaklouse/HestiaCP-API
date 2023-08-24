<?php

namespace HestiaCP\Command\Add;

use HestiaCP\Command\ProcessCommand;

class DnsRemoteDomain extends ProcessCommand
{
	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var bool */
	private $flush;

	public function __construct(string $user, string $domain, bool $flush = false)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->flush = $flush;
	}

	public function getName(): string
	{
		return 'v-add-remote-dns-domain';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->convertBool($this->flush)
		];
	}
}