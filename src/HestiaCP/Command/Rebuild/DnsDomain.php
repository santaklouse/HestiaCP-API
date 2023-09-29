<?php

namespace HestiaCP\Command\Rebuild;

use HestiaCP\Command\ProcessCommand;

class DnsDomain extends ProcessCommand
{
	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var bool */
	private $restart;

    /** @var bool */
	private $update_serial;

	public function __construct(string $user, string $domain, bool $restart = true, bool $update_serial = true)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->restart = $restart;
        $this->update_serial = $update_serial;
	}

	public function getName(): string
	{
		return 'v-rebuild-dns-domain';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->convertBool($this->restart),
            self::ARG_4 => $this->convertBool($this->update_serial)
		];
	}
}