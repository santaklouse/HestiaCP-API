<?php

namespace HestiaCP\Command\Change;

use HestiaCP\Command\ProcessCommand;

class DnsDomainRecord extends ProcessCommand
{

	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var int */
	private $id;

	/** @var string */
	private $record;

	/** @var string */
	private $type;

	/** @var string */
	private $value;

	/** @var int */
	private $priority;

	/** @var bool */
	private $restart;

	/** @var int */
	private $ttl;

	public function __construct(string $user, string $domain, int $id, string $record, string $type, string $value, int $priority = null, bool $restart = false, int $ttl = 7200)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->id = $id;
		$this->record = $record;
		$this->type = $type;
		$this->value = $value;
		$this->priority = $priority;
		$this->restart = $restart;
		$this->ttl = $ttl;
	}

	public function getName(): string
	{
		return 'v-change-dns-record';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->id,
			self::ARG_4 => $this->record,
			self::ARG_5 => $this->type,
			self::ARG_6 => $this->value,
			self::ARG_7 => $this->priority === NULL ? '' : $this->priority,
			self::ARG_8 => $this->convertBool($this->restart),
			self::ARG_9 => $this->ttl
		];
	}
}