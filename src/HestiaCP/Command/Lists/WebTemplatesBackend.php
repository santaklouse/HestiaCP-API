<?php

namespace HestiaCP\Command\Lists;

use HestiaCP\Command\ListCommand;

class WebBackendTemplates extends ListCommand {

	public function getName(): string {
		return 'v-list-web-templates-backend';
	}

	public function getRequestParams(): array {
		return [
			self::ARG_1 => self::FORMAT_JSON
		];
	}
}
