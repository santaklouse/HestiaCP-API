<?php

namespace HestiaCP\Command\Lists;

use Nette\Utils\ArrayHash;
use HestiaCP\Command\ListCommand;

class DnsPublicKey extends ListCommand
{

    /** @var string */
    private $user;

    /** @var string */
    private $domain;

    /** @var string */
    private $dnstype;

    public function __construct(string $user, string $domain, string $dnstype = '')
    {
        $this->user = $user;
        $this->domain = $domain;
        $this->dnstype = $dnstype;
    }

    public function getName(): string
    {
        return 'v-list-dns-public-key';
    }

    public function process(): ArrayHash
    {
        return $this->convertDetail(parent::process());
    }

    public function getRequestParams(): array
    {
        return [
            self::ARG_1 => $this->user,
            self::ARG_2 => $this->domain,
            self::ARG_3 => self::FORMAT_JSON,
            self::ARG_4 => $this->dnstype
        ];
    }
}