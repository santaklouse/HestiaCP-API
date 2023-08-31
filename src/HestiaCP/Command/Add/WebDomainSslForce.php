<?php

namespace HestiaCP\Command\Add;

use HestiaCP\Command\ProcessCommand;

class WebDomainSslForce extends ProcessCommand {

	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	public function __construct(string $user, string $domain) {
		$this->user = $user;
		$this->domain = $domain;
	}

	public function getName(): string {
		return 'v-add-web-domain-ssl-force';
	}

	public function getRequestParams(): array {
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain
		];
	}
}
