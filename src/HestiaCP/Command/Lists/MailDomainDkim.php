<?php

namespace HestiaCP\Command\Lists;

use HestiaCP\Command\ListCommand;

class MailDomainDkim extends ListCommand {

	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	public function __construct(string $user, string $domain) {
		$this->user = $user;
		$this->domain = $domain;
	}

	public function getName(): string {
		return 'v-list-mail-domain-dkim';
	}

	public function getResponseText(): string {
		// bug, issue 1827 ( https://github.com/serghey-rodin/vesta/issues/1827 )
		return preg_replace('~\,\s*\}~', '}', parent::getResponseText());
	}

	public function getRequestParams(): array {
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => self::FORMAT_JSON
		];
	}
}
