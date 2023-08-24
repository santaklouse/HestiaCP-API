<?php

namespace HestiaCP\Command\Lists;

use Nette\Utils\ArrayHash;
use HestiaCP\Command\ListCommand;

class DnsTemplates extends ListCommand
{
    public function getName(): string
    {
        return 'v-list-dns-templates';
    }

    public function process(): ArrayHash
    {
        return $this->convertDetail(parent::process());
    }

    public function getRequestParams(): array
    {
        return [
            self::ARG_1 => self::FORMAT_JSON
        ];
    }
}