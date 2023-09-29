<?php

namespace HestiaCP\Command\Add;

use HestiaCP\Command\ProcessCommand;

class DnsRecord extends ProcessCommand
{

	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var string */
	private $record;

	/** @var string */
	private $rtype;

	/** @var string */
	private $dvalue;

	/** @var int */
	private $priority;

	/** @var int */
	private $id;

	/** @var bool */
	private $restart;

	/** @var int */
	private $ttl;

	public function __construct(string $user, string $domain, string $record, string $rtype, string $dvalue, int $priority = null, int $id = null, bool $restart = false, int $ttl = 7200)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->record = $record;
		$this->rtype = $rtype;
		$this->dvalue = $dvalue;
		$this->priority = $priority;
		$this->id = $id;
		$this->restart = $restart;
		$this->ttl = $ttl;
	}

	public function getName(): string
	{
		return 'v-add-dns-record';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->record,
			self::ARG_4 => $this->rtype,
			self::ARG_5 => $this->dvalue,
			self::ARG_6 => $this->priority === NULL ? '' : $this->priority,
			self::ARG_7 => $this->id === NULL ? '' : $this->id,
			self::ARG_8 => $this->convertBool($this->restart),
			self::ARG_9 => $this->ttl
		];
	}
}