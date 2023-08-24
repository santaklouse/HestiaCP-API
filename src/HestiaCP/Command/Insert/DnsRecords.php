<?php

namespace HestiaCP\Command\Insert;

use HestiaCP\Command\ProcessCommand;

class DnsRecords extends ProcessCommand
{
	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var string */
	private $data_file;

	public function __construct(string $user, string $domain, string $data_file)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->data_file = $data_file;
	}

	public function getName(): string
	{
		return 'v-insert-dns-records';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->data_file
		];
	}
}