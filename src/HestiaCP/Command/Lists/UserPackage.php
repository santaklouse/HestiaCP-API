<?php

namespace HestiaCP\Command\Lists;

use HestiaCP\Command\ListCommand;

class UserPackage extends ListCommand {

    /** @var string */
    private $package;

    public function __construct(string $package) {
        $this->package = $package;
    }

    public function getName(): string {
        return 'v-list-user-package';
    }

    public function getRequestParams(): array {
        return [
            self::ARG_1 => $this->package,
            self::ARG_2 => self::FORMAT_JSON
        ];
    }
}
