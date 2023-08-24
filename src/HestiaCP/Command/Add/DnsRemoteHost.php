<?php

namespace HestiaCP\Command\Add;

use HestiaCP\Command\ProcessCommand;

class DnsRemoteHost extends ProcessCommand
{
	/** @var string */
	private $host;

	/** @var int */
	private $port;

	/** @var string */
	private $api_key;

	/** @var string */
	private $password;

	/** @var string */
	private $type;

	/** @var string */
	private $dns_user;

	public function __construct(string $host, int $port, string $api_key, string $password = null, string $type = 'api', string $dns_user)
	{
		$this->host = $host;
		$this->port = $port;
		$this->api_key = $api_key;
		$this->password = $password;
		$this->type = $type;
		$this->dns_user = $dns_user;
	}

	public function getName(): string
	{
		return 'v-add-remote-dns-host';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->host,
			self::ARG_2 => $this->port,
			self::ARG_3 => $this->api_key,
			self::ARG_4 => $this->password,
			self::ARG_5 => $this->type,
			self::ARG_6 => $this->dns_user
		];
	}
}