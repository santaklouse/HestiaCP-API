<?php

namespace HestiaCP\Command\Lists;

use HestiaCP\Command\ListCommand;

class Users extends ListCommand {

	public function getName(): string {
		return 'v-list-users';
	}

	public function getRequestParams(): array {
		return [
			self::ARG_1 => self::FORMAT_JSON
		];
	}
}
