<?php

namespace HestiaCP\Command\Lists;

use Nette\Utils\ArrayHash;
use HestiaCP\Command\ListCommand;

class DnsDomains extends ListCommand
{

    /** @var string */
    private $user;

    public function __construct(string $user)
    {
        $this->user = $user;
    }

    public function getName(): string
    {
        return 'v-list-dns-domains';
    }

    public function process(): ArrayHash
    {
        return $this->convertDetail(parent::process());
    }

    public function getRequestParams(): array
    {
        return [
            self::ARG_1 => $this->user,
            self::ARG_2 => self::FORMAT_JSON
        ];
    }
}