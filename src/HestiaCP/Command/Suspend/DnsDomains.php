<?php

namespace HestiaCP\Command\Suspend;

use HestiaCP\Command\ProcessCommand;

class DnsDomains extends ProcessCommand
{

    /** @var string */
    private $user;

    /** @var bool */
    private $restart;

    public function __construct(string $user, bool $restart = false)
    {
        $this->user = $user;
        $this->restart = $restart;
    }

    public function getName(): string
    {
        return 'v-suspend-dns-domains';
    }

    public function getRequestParams(): array
    {
        return [
            self::ARG_1 => $this->user,
            self::ARG_3 => $this->convertBool($this->restart)
        ];
    }
}