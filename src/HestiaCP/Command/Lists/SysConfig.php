<?php

namespace HestiaCP\Command\Lists;

use HestiaCP\Command\ListCommand;

class SysConfig extends ListCommand {

	public function getName(): string {
		return 'v-list-sys-config';
	}

	public function getRequestParams(): array {
		return [
			self::ARG_1 => self::FORMAT_JSON
		];
	}
}