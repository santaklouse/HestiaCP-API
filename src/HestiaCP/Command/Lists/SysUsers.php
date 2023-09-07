<?php

namespace HestiaCP\Command\Lists;

use HestiaCP\Command\ListCommand;

class SysUsers extends ListCommand {

	public function getName(): string {
		return 'v-list-sys-users';
	}

	public function getRequestParams(): array {
		return [
			self::ARG_1 => self::FORMAT_JSON
		];
	}
}