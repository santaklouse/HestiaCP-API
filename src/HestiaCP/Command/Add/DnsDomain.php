<?php

namespace HestiaCP\Command\Add;

use HestiaCP\Command\ProcessCommand;

class DnsDomain extends ProcessCommand
{
	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var string */
	private $ip;

	/** @var string */
	private $ns1;

	/** @var string */
	private $ns2;

	/** @var string */
	private $ns3;

	/** @var string */
	private $ns4;

	/** @var string */
	private $ns5;

	/** @var string */
	private $ns6;

	/** @var string */
	private $ns7;

	/** @var string */
	private $ns8;

	/** @var bool */
	private $restart;

	public function __construct(string $user, string $domain, string $ip, string $ns1, string $ns2, string $ns3 = null, string $ns4 = null, string $ns5 = null, string $ns6 = null, string $ns7 = null, string $ns8 = null, bool $restart = false)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->ip = $ip;
		$this->ns1 = $ns1;
		$this->ns2 = $ns2;
		$this->ns3 = $ns3;
		$this->ns4 = $ns4;
		$this->ns5 = $ns5;
		$this->ns6 = $ns6;
		$this->ns7 = $ns7;
		$this->ns8 = $ns8;
		$this->restart = $restart;
	}

	public function getName(): string
	{
		return 'v-add-dns-domain';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->ip,
			self::ARG_4 => $this->ns1,
			self::ARG_5 => $this->ns2,
			self::ARG_6 => $this->ns3,
			self::ARG_7 => $this->ns4,
			self::ARG_8 => $this->ns5,
			self::ARG_9 => $this->ns6,
			self::ARG_10 => $this->ns7,
			self::ARG_11 => $this->ns8,
			self::ARG_12 => $this->convertBool($this->restart)
		];
	}
}