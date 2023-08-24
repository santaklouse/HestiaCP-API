<?php

namespace HestiaCP\Module;

use Nette\Utils\ArrayHash;
use HestiaCP\Client;
use HestiaCP\Command\Add\MailAccount;
use HestiaCP\Command\Add\MailDomain;
use HestiaCP\Command\Change\MailAccountPassword;
use HestiaCP\Command\Suspend\MailAccount as SuspendMailAccount;
use HestiaCP\Command\Suspend\MailDomain as SuspendMailDomain;
use HestiaCP\Command\Unsuspend\MailAccount as UnsuspendMailAccount;
use HestiaCP\Command\Unsuspend\MailDomain as UnsuspendMailDomain;
use HestiaCP\Command\Delete\MailAccount as DeleteMailAccount;
use HestiaCP\Command\Delete\MailDomain as DeleteMailDomain;
use HestiaCP\Command\Lists\MailAccounts;
use HestiaCP\Command\Lists\MailDomainDkim;
use HestiaCP\Command\Lists\MailDomainDkimDns;
use HestiaCP\Command\Lists\MailDomains;

class Mails extends Module {

	/** @var string */
	private $user;

	public function __construct(Client $client, string $user) {
		parent::__construct($client);
		$this->user = $user;
	}

	/**
	 * This function of obtaining the list of all user domains.
	 * 
	 * @param string $domain
	 * @return ArrayHash[]
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listAccounts(string $domain): array {
		return $this->client->send(new MailAccounts($this->user, $domain));
	}

	/**
	 * This function add new email account.
	 * 
	 * @param string $domain
	 * @param string $account
	 * @param string $password
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addAccount(string $domain, string $account, string $password): bool {
		return $this->client->send(new MailAccount($this->user, $domain, $account, $password));
	}

	/**
	 * This function changes email account password.
	 * 
	 * @param string $domain
	 * @param string $account
	 * @param string $password
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeAccountPassword(string $domain, string $account, string $password): bool {
		return $this->client->send(new MailAccountPassword($this->user, $domain, $account, $password));
	}

	/**
	 * This function suspends mail account.
	 * 
	 * @param string $domain
	 * @param string $account
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function suspendAccount(string $domain, string $account): bool {
		return $this->client->send(new SuspendMailAccount($this->user,  $domain, $account));
	}

	/**
	 * This function unsuspends mail account.
	 * 
	 * @param string $domain
	 * @param string $account
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function unsuspendAccount(string $domain, string $account): bool {
		return $this->client->send(new UnsuspendMailAccount($this->user,  $domain, $account));
	}

	/**
	 * This function deletes email account.
	 * 
	 * @param string $domain
	 * @param string $account
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function deleteAccount(string $domain, string $account): bool {
		return $this->client->send(new DeleteMailAccount($this->user, $domain, $account));
	}

	/**
	 * This function adds MAIL domain.
	 * 
	 * @param string $domain
	 * @param bool   $antispam
	 * @param bool   $antivirus
	 * @param bool   $dkim
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addDomain(string $domain, bool $antispam = true, bool $antivirus = true, bool $dkim = true): bool {
		return $this->client->send(new MailDomain($this->user, $domain, $antispam, $antivirus, $dkim));
	}

	/**
	 * This function suspends mail domain.
	 * 
	 * @param string $domain
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function suspendDomain(string $domain): bool {
		return $this->client->send(new SuspendMailDomain($this->user, $domain));
	}

	/**
	 * This function unsuspends mail domain.
	 * 
	 * @param string $domain
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function unsuspendDomain(string $domain): bool {
		return $this->client->send(new UnsuspendMailDomain($this->user, $domain));
	}

	/**
	 * This function for deleting MAIL domain. By deleting it all accounts will also be deleted.
	 * 
	 * @param string $domain
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function deleteDomain(string $domain): bool {
		return $this->client->send(new DeleteMailDomain($this->user, $domain));
	}

	/**
	 * This function of obtaining domain dkim files.
	 * 
	 * @param string $domain
	 * @return ArrayHash[]
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listDomainDkim(string $domain): array {
		return $this->client->send(new MailDomainDkim($this->user, $domain));
	}

	/**
	 * This function of obtaining domain dkim dns records for proper setup.
	 * 
	 * @param string $domain
	 * @return ArrayHash[]
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listDomainDkimDns(string $domain): array {
		return $this->client->send(new MailDomainDkimDns($this->user, $domain));
	}

	/**
	 * This function of obtaining the list of all user domains.
	 * 
	 * @return ArrayHash[]
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listDomains(): array {
		return $this->client->send(new MailDomains($this->user));
	}
}
