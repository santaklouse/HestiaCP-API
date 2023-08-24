<?php

namespace HestiaCP\Command\Rebuild;

use HestiaCP\Command\ProcessCommand;

class DnsDomains extends ProcessCommand
{
	/** @var string */
	private $user;

	/** @var bool */
	private $restart;

    /** @var bool */
	private $update_serial;

	public function __construct(string $user, bool $restart = false, bool $update_serial)
	{
		$this->user = $user;
		$this->restart = $restart;
        $this->update_serial = $update_serial;
	}

	public function getName(): string
	{
		return 'v-rebuild-dns-domains';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->convertBool($this->restart),
            self::ARG_3 => $this->update_serial
		];
	}
}