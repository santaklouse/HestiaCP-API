<?php

namespace HestiaCP\Command\Insert;

use HestiaCP\Command\ProcessCommand;

class DnsRecord extends ProcessCommand
{
	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var string */
	private $data;

	public function __construct(string $user, string $domain, string $data)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->data = $data;
	}

	public function getName(): string
	{
		return 'v-insert-dns-record';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->data
		];
	}
}