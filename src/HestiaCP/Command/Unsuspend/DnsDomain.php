<?php

namespace HestiaCP\Command\Unsuspend;

use HestiaCP\Command\ProcessCommand;

class DnsDomain extends ProcessCommand {

    /** @var string */
    private $user;

    /** @var string */
    private $domain;

    public function __construct(string $user, string $domain) {
        $this->user = $user;
        $this->domain = $domain;
    }

    public function getName(): string {
        return 'v-unsuspend-dns-domain';
    }

    public function getRequestParams(): array {
        return [
            self::ARG_1 => $this->user,
            self::ARG_2 => $this->domain,
        ];
    }
}
