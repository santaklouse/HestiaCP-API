<?php

namespace HestiaCP\Command\Change;

use HestiaCP\Command\ProcessCommand;

class DnsDomainExp extends ProcessCommand {

	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var string */
	private $expiration;

	public function __construct(string $user, string $domain, string $expiration) {
		$this->user = $user;
		$this->domain = $domain;
		$this->expiration = $expiration;
	}

	public function getName(): string {
		return 'v-change-dns-domain-exp';
	}

	public function getRequestParams(): array {
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->expiration,
		];
	}
}