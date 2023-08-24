<?php

namespace HestiaCP\Command\Change;

use HestiaCP\Command\ProcessCommand;

class DnsDomainDnssec extends ProcessCommand {

	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var bool */
	private $status;

	public function __construct(string $user, string $domain, bool $status) {
		$this->user = $user;
		$this->domain = $domain;
		$this->status = $status;
	}

	public function getName(): string {
		return 'v-change-dns-domain-dnssec';
	}

	public function getRequestParams(): array {
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->status,
		];
	}
}