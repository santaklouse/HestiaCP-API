<?php

namespace HestiaCP\Command\Change;

use HestiaCP\Command\ProcessCommand;

class WebDomainDocroot extends ProcessCommand
{

	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var string */
	private $target_domain;

	/** @var string */
	private $directory;

	public function __construct(string $user, string $domain, string $target_domain, string $directory)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->target_domain = $target_domain;
		$this->directory = $directory;
	}

	public function getName(): string
	{
		return 'v-change-web-domain-docroot';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->target_domain,
			self::ARG_4 => $this->directory
		];
	}
}