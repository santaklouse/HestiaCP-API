<?php

namespace HestiaCP\Command\Lists;

use Nette\Utils\ArrayHash;
use HestiaCP\Command\ListCommand;

class DnsTemplate extends ListCommand
{

    /** @var string */
    private $template;

    public function __construct(string $template)
    {
        $this->template = $template;
    }

    public function getName(): string
    {
        return 'v-list-dns-template';
    }

    public function process(): ArrayHash
    {
        return $this->convertDetail(parent::process());
    }

    public function getRequestParams(): array
    {
        return [
            self::ARG_1 => $this->template,
            self::ARG_2 => self::FORMAT_JSON
        ];
    }
}