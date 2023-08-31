<?php

namespace HestiaCP\Command\Change;

use HestiaCP\Command\ProcessCommand;

class WebDomainProxyTpl extends ProcessCommand
{

	/** @var string */
	private $user;

	/** @var string */
	private $domain;

	/** @var string */
	private $template;

	/** @var string */
	private $extensions = "jpg,jpeg,gif,png,ico,svg,css,zip,tgz,gz,rar,bz2,doc,xls,exe,pdf,ppt,txt,odt,ods,odp,odf,tar,wav,bmp,rtf,js,mp3,avi,mpeg,flv,html,htm";

	/** @var bool */
	private $restart;

	public function __construct(string $user, string $domain, string $template, string $extensions, bool $restart)
	{
		$this->user = $user;
		$this->domain = $domain;
		$this->template = $template;
		$this->extensions = $extensions;
		$this->restart = $restart;
	}

	public function getName(): string
	{
		return 'v-change-web-domain-proxy-tpl';
	}

	public function getRequestParams(): array
	{
		return [
			self::ARG_1 => $this->user,
			self::ARG_2 => $this->domain,
			self::ARG_3 => $this->template,
			self::ARG_4 => $this->extensions,
			self::ARG_5 => $this->convertBool($this->restart)
		];
	}
}