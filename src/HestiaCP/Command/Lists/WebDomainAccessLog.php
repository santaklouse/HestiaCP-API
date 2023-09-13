<?php

namespace HestiaCP\Command\Lists;

use HestiaCP\Command\ListCommand;

class WebDomainAccessLog extends ListCommand
{

	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var int */
	private $lines;

	public function __construct(string $user, string $domain, int $lines)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->lines = $lines;
	}

	public function getName(): string
	{
		return 'v-list-web-domain-accesslog';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->lines,
			self::ARG_4 => self::FORMAT_JSON
		];
	}
}