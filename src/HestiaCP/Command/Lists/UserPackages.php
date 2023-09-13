<?php

namespace HestiaCP\Command\Lists;

use HestiaCP\Command\ListCommand;

class UserPackages extends ListCommand {

    public function getName(): string {
        return 'v-list-user-packages';
    }

    public function getRequestParams(): array {
        return [
            self::ARG_1 => self::FORMAT_JSON
        ];
    }
}
