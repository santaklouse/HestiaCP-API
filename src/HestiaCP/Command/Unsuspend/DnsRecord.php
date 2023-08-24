<?php

namespace HestiaCP\Command\Unsuspend;

use HestiaCP\Command\ProcessCommand;

class DnsRecord extends ProcessCommand
{

    /** @var string */
    private $user;

    /** @var string */
    private $domain;

    /** @var int */
    private $id;

    /** @var bool */
    private $restart;

    public function __construct(string $user, string $domain, int $id, bool $restart = true)
    {
        $this->user = $user;
        $this->domain = $domain;
        $this->id = $id;
        $this->restart = $restart;
    }

    public function getName(): string
    {
        return 'v-unsuspend-dns-record';
    }

    public function getRequestParams(): array
    {
        return [
            self::ARG_1 => $this->user,
            self::ARG_2 => $this->domain,
            self::ARG_3 => $this->id,
            self::ARG_4 => $this->convertBool($this->restart)
        ];
    }
}