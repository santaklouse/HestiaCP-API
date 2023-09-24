<?php

namespace HestiaCP\Module;

use Nette\Utils\ArrayHash;
use HestiaCP\Client;
use HestiaCP\Command\Add\LetsEncryptDomain;
use HestiaCP\Command\Add\WebDomain;
use HestiaCP\Command\Add\WebDomainFtp;
use HestiaCP\Command\Add\WebDomainSslHsts as AddWebDomainSslHsts;
use HestiaCP\Command\Add\WebDomainSslForce as AddWebDomainSslForce;
use HestiaCP\Command\Add\FsDirectory;
use HestiaCP\Command\Change\WebDomainFtpPassword;
use HestiaCP\Command\Change\WebDomainFtpPath;
use HestiaCP\Command\Change\WebDomainBackendTpl;
use HestiaCP\Command\Change\WebDomainProxyTpl;
use HestiaCP\Command\Change\WebDomainDocroot;
use HestiaCP\Command\Suspend\WebDomain as SuspendWebDomain;
use HestiaCP\Command\Unsuspend\WebDomain as UnsuspendWebDomain;
use HestiaCP\Command\Delete\LetsEncryptDomain as DeleteLetsEncryptDomain;
use HestiaCP\Command\Delete\WebDomain as DeleteWebDomain;
use HestiaCP\Command\Delete\WebDomainFtp as DeleteWebDomainFtp;
use HestiaCP\Command\Delete\WebDomainSslHsts as DeleteWebDomainSslHsts;
use HestiaCP\Command\Delete\WebDomainSslForce as DeleteWebDomainSslForce;
use HestiaCP\Command\Lists\WebDomains;
use HestiaCP\Command\Lists\WebDomain as ListWebDomain;
use HestiaCP\Command\Lists\WebBackendTemplates;
use HestiaCP\Command\Lists\WebDomainSsl;
use HestiaCP\Command\Lists\WebDomainAccessLog;
use HestiaCP\Command\Lists\WebDomainErrorLog;
use HestiaCP\Command\Purge\NginxCache;

class Webs extends Module
{

	/** @var string */
	private $user;

	public function __construct(Client $client, string $user = null)
	{
		parent::__construct($client);
		$this->user = $user;
	}

	/**
	 * This function adds virtual host to a server.
	 * 
	 * @param string      $domain
	 * @param string|null $ip
	 * @param string|null $aliases
	 * @param string|null $proxyExtensions
	 * @param bool        $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addDomain(string $domain, string $ip = null, string $aliases = null, string $proxyExtensions = null, bool $restart = true): bool
	{
		return $this->client->send(new WebDomain($this->user, $domain, $ip, $aliases, $proxyExtensions, $restart));
	}

	/**
	 * This function for suspending the site's operation. 
	 * 
	 * @param string      $domain
	 * @param bool        $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function suspendDomain(string $domain, bool $restart = true): bool
	{
		return $this->client->send(new SuspendWebDomain($this->user, $domain, $restart));
	}

	/**
	 * This function of unsuspending the domain.
	 * 
	 * @param string      $domain
	 * @param bool        $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function unsuspendDomain(string $domain, bool $restart = true): bool
	{
		return $this->client->send(new UnsuspendWebDomain($this->user, $domain, $restart));
	}

	/**
	 * This call of function leads to the removal of domain and all its components (statistics, folders contents, ssl certificates, etc.).
	 * 
	 * @param string $domain
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function deleteDomain(string $domain): bool
	{
		return $this->client->send(new DeleteWebDomain($this->user, $domain));
	}

	/**
	 * This function check and validates domain with Let's Encrypt
	 * 
	 * @param string      $domain
	 * @param string|null $aliases
	 * @param string|null $mail
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addDomainLetsEncrypt(string $domain, string $aliases = null, string $mail = null): bool
	{
		return $this->client->send(new LetsEncryptDomain($this->user, $domain, $aliases, $mail));
	}

	/**
	 * This function turns off letsencrypt SSL support for a domain.
	 * 
	 * @param string $domain
	 * @param bool   $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function deleteDomainLetsEncrypt(string $domain, bool $restart = true): bool
	{
		return $this->client->send(new DeleteLetsEncryptDomain($this->user, $domain, $restart));
	}

	/**
	 * This function creates additional ftp account for web domain.
	 * 
	 * @param string      $domain
	 * @param string      $ftpUser
	 * @param string      $ftpPassword
	 * @param string|null $ftpPath
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addDomainFtp(string $domain, string $ftpUser, string $ftpPassword, string $ftpPath = null): bool
	{
		return $this->client->send(new WebDomainFtp($this->user, $domain, $ftpUser, $ftpPassword, $ftpPath));
	}

	/**
	 * This function changes ftp user password.
	 * 
	 * @param string      $domain
	 * @param string      $ftpUser
	 * @param string      $ftpPassword
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeDomainFtpPassword(string $domain, string $ftpUser, string $ftpPassword): bool
	{
		return $this->client->send(new WebDomainFtpPassword($this->user, $domain, $ftpUser, $ftpPassword));
	}

	/**
	 * This function changes ftp user path.
	 * 
	 * @param string $domain
	 * @param string $ftpUser
	 * @param string $ftpPath
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeDomainFtpPath(string $domain, string $ftpUser, string $ftpPath): bool
	{
		return $this->client->send(new WebDomainFtpPath($this->user, $domain, $ftpUser, $ftpPath));
	}

	/**
	 * This function deletes additional ftp account.
	 * 
	 * @param string $domain
	 * @param string $ftpUser
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function deleteDomainFtp(string $domain, string $ftpUser): bool
	{
		return $this->client->send(new DeleteWebDomainFtp($this->user, $domain, $ftpUser));
	}

	/**
	 * This function to obtain the list of all user web domains.
	 * 
	 * @return ArrayHash[]
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listDomains(): array
	{
		return $this->client->send(new WebDomains($this->user));
	}

	/**
	 * This function changes backend template for domain.
	 * 
	 * @param string $domain
	 * @param string $template
	 * @param bool   $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeDomainBackendTpl(string $domain, string $template, bool $restart = true): bool
	{
		return $this->client->send(new WebDomainBackendTpl($this->user, $domain, $template, $restart));
	}

	/**
	 * This function to obtain the list of all backend templates.
	 * 
	 * @return ArrayHash[]
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listBackendTemplates(): array
	{
		return $this->client->send(new WebBackendTemplates());
	}

	/**
	 * This function of obtaining domain ssl files.
	 * 
	 * @param string $domain
	 * @return array
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function getDomainSSLinfo(string $domain): array
	{
		return $this->client->send(new WebDomainSsl($this->user, $domain));
	}

	/**
	 * This function to obtain web domain parameters.
	 * 
	 * @param string $domain
	 * @return array
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listWebDomain(string $domain): array
	{
		return $this->client->send(new ListWebDomain($this->user, $domain));
	}

	/**
	 * This function enables HSTS for the requested domain.
	 * 
	 * @param string $domain
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addWebDomainSslHsts(string $domain): bool
	{
		return $this->client->send(new AddWebDomainSslHsts($this->user, $domain));
	}

	/**
	 * This function disables HSTS for the requested domain.
	 * 
	 * @param string $domain
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function deleteWebDomainSslHsts(string $domain): bool
	{
		return $this->client->send(new DeleteWebDomainSslHsts($this->user, $domain));
	}

	/**
	 * This function forces SSL for the requested domain.
	 * 
	 * @param string $domain
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addWebDomainSslForce(string $domain): bool
	{
		return $this->client->send(new AddWebDomainSslForce($this->user, $domain));
	}

	/**
	 * This function removes force SSL configurations.
	 * 
	 * @param string $domain
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function deleteWebDomainSslForce(string $domain): bool
	{
		return $this->client->send(new DeleteWebDomainSslForce($this->user, $domain));
	}

	/**
	 * This function purges nginx cache.
	 * 
	 * @param string $domain
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function purgeNginxCache(string $domain): bool
	{
		return $this->client->send(new NginxCache($this->user, $domain));
	}

	/**
	 * This function changes proxy template.
	 * 
	 * @param string $domain
	 * @param string $template
	 * @param string $extensions
	 * @param bool $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeDomainProxyTpl(string $domain, string $template, string $extensions, bool $restart = true): bool
	{
		return $this->client->send(new WebDomainProxyTpl($this->user, $domain, $template, $extensions, $restart));
	}

	/**
	 * Changes the document root for an existing web domain.
	 * 
	 * @param string $domain
	 * @param string|null $target_domain
	 * @param string $directory
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeDomainDocroot(string $domain, string $target_domain = null, string $directory = 'default'): bool
	{
		return $this->client->send(new WebDomainDocroot($this->user, $domain, $target_domain, $directory));
	}

	/**
	 * This function creates new directory on the file system.
	 * 
	 * @param string $path
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addNewDir(string $path): bool
	{
		return $this->client->send(new FsDirectory($this->user, $path));
	}

	/**
	 * This function of obtaining raw access web domain logs.
	 * 
	 * @param string $domain
	 * @param int $lines
	 * @return array
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function getAccessLog(string $domain, int $lines = 50): array
	{
		return $this->client->send(new WebDomainAccessLog($this->user, $domain, $lines));
	}

	/**
	 * This function of obtaining raw error web domain logs.
	 * 
	 * @param string $domain
	 * @param int $lines
	 * @return array
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function getErrorLog(string $domain, int $lines = 50): array
	{
		return $this->client->send(new WebDomainErrorLog($this->user, $domain, $lines));
	}
}