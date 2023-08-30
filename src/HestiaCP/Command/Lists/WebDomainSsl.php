<?php

namespace HestiaCP\Command\Lists;

use HestiaCP\Command\ListCommand;

class WebDomainSsl extends ListCommand
{

    /** @var string */
    private $user;

    /** @var string */
    private $domain;

    public function __construct(string $user, string $domain)
    {
        $this->user = $user;
        $this->domain = $domain;
    }

    public function getName(): string
    {
        return 'v-list-web-domain-ssl';
    }

    public function getRequestParams(): array
    {
        return [
            self::ARG_1 => $this->user,
            self::ARG_2 => $this->domain,
            self::ARG_3 => self::FORMAT_JSON
        ];
    }
}