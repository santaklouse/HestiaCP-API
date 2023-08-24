<?php

namespace HestiaCP\Command\Insert;

use HestiaCP\Command\ProcessCommand;

class DnsDomain extends ProcessCommand
{
	/** @var string */
	private $user;

	/** @var string */
	private $data;

	/** @var string */
	private $src;

    /** @var bool */
	private $flush;

	public function __construct(string $user, string $data, string $src, bool $flush = false)
	{
		$this->user = $user;
		$this->data = $data;
		$this->src = $src;
        $this->flush = $flush;
	}

	public function getName(): string
	{
		return 'v-insert-dns-domain';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->data,
			self::ARG_3 => $this->src,
            self::ARG_4 => $this->convertBool($this->flush)
		];
	}
}