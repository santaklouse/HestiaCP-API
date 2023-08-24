<?php

namespace HestiaCP\Command\Add;

use HestiaCP\Command\ProcessCommand;

class DnsRemoteRecord extends ProcessCommand
{
	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var int */
	private $id;

	public function __construct(string $user, string $domain, int $id)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->id = $id;
	}

	public function getName(): string
	{
		return 'v-add-remote-dns-record';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->id
		];
	}
}