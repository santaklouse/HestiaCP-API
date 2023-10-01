<?php

namespace HestiaCP\Module;

use Nette\Utils\ArrayHash;
use HestiaCP\Command\Add\DnsRecord;
use HestiaCP\Command\Add\DnsDomain;
use HestiaCP\Command\Add\DnsOnWebAlias;
use HestiaCP\Command\Add\DnsRemoteDomain;
use HestiaCP\Command\Add\DnsRemoteHost;
use HestiaCP\Command\Add\DnsRemoteRecord;
use HestiaCP\Command\Change\DnsDomainTpl;
use HestiaCP\Command\Change\DnsDomainDnssec;
use HestiaCP\Command\Change\DnsDomainExp;
use HestiaCP\Command\Change\DnsDomainIp;
use HestiaCP\Command\Change\DnsDomainSoa;
use HestiaCP\Command\Change\DnsDomainTtl;
use HestiaCP\Command\Change\DnsDomainRecord;
use HestiaCP\Command\Delete\DnsDomain as DnsDomainDelete;
use HestiaCP\Command\Delete\DnsDomains as DnsDomainsDelete;
use HestiaCP\Command\Delete\DnsDomainsSrc;
use HestiaCP\Command\Delete\DnsOnWebAlias as DeleteDnsOnWebAlias;
use HestiaCP\Command\Delete\DnsRecord as DeleteDnsRecord;
use HestiaCP\Command\Get\DnsDomainValue;
use HestiaCP\Command\Insert\DnsDomain as InsertDnsDomain;
use HestiaCP\Command\Insert\DnsRecord as InsertDnsRecord;
use HestiaCP\Command\Insert\DnsRecords as InsertDnsRecords;
use HestiaCP\Command\Lists\DnsDomain as ListDnsDomain;
use HestiaCP\Command\Lists\DnsDomains as ListDnsDomains;
use HestiaCP\Command\Lists\DnsRecords as ListDnsRecords;
use HestiaCP\Command\Lists\DnsTemplate as ListDnsTemplate;
use HestiaCP\Command\Lists\DnsTemplates as ListDnsTemplates;
use HestiaCP\Command\Lists\DnsPublicKey;
use HestiaCP\Command\Lists\DnsMailDomainDkim;
use HestiaCP\Command\Lists\DnsRemoteHosts;
use HestiaCP\Command\Rebuild\DnsDomain as RebuildDnsDomain;
use HestiaCP\Command\Rebuild\DnsDomains as RebuildDnsDomains;
use HestiaCP\Command\Suspend\DnsDomain as SuspendDnsDomain;
use HestiaCP\Command\Suspend\DnsDomains as SuspendDnsDomains;
use HestiaCP\Command\Suspend\DnsRecord as SuspendDnsRecord;
use HestiaCP\Command\Unsuspend\DnsDomain as UnsuspendDnsDomain;
use HestiaCP\Command\Unsuspend\DnsDomains as UnsuspendDnsDomains;
use HestiaCP\Command\Unsuspend\DnsRecord as UnsuspendDnsRecord;

class DNS extends Module
{
	/**
	 * This function adds new dns record.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param string 	  $record
	 * @param string      $rtype
	 * @param string      $dvalue
	 * @param int|null    $priority
	 * @param int|null    $id
	 * @param bool        $restart
	 * @param int|null    $ttl
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addDNSRecord(string $user, string $domain, string $record, string $rtype, string $dvalue, int $priority = null, int $id = null, bool $restart = true, int $ttl = 7200): bool
	{
		return $this->client->send(new DnsRecord($user, $domain, $record, $rtype, $dvalue, $priority, $id, $restart, $ttl));
	}

	/**
	 * This function adds DNS zone with records defined in the template.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param string 	  $ip
	 * @param string      $ns1
	 * @param string      $ns2
	 * @param string      $ns3
	 * @param string      $ns4
	 * @param string      $ns5
	 * @param string      $ns6
	 * @param string      $ns7
	 * @param string      $ns8
	 * @param bool        $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addDNSDomain(string $user, string $domain, string $ip, string $ns1, string $ns2, string $ns3 = null, string $ns4 = null, string $ns5 = null, string $ns6 = null, string $ns7 = null, string $ns8 = null, bool $restart = true): bool
	{
		return $this->client->send(new DnsDomain($user, $domain, $ip, $ns1, $ns2, $ns3, $ns4, $ns5, $ns6, $ns7, $ns8, $restart));
	}

	/**
	 * This function adds dns domain or dns record based on web domain alias.
	 * 
	 * @param string 	  $user
	 * @param string 	  $alias
	 * @param string 	  $ip
	 * @param bool        $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addDNSOnWebAlias(string $user, string $alias, string $ip, bool $restart = true): bool
	{
		return $this->client->send(new DnsOnWebAlias($user, $alias, $ip, $restart));
	}

	/**
	 * This function synchronise dns domain with the remote server.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param bool        $flush
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addDNSRemoteDomain(string $user, string $domain, bool $flush = false): bool
	{
		return $this->client->send(new DnsRemoteDomain($user, $domain, $flush));
	}

	/**
	 * This function adds remote dns server to the dns cluster. Only API key supported, not legacy password auth!
	 * 
	 * @param string 	  $host
	 * @param int 	  	  $port
	 * @param string      $api_key
	 * @param string      $password
	 * @param string      $type
	 * @param string      $dns_user
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addDNSRemoteHost(string $host, int $port, string $api_key, string $password = null, string $type = 'api', string $dns_user = null): bool
	{
		return $this->client->send(new DnsRemoteHost($host, $port, $api_key, $password, $type, $dns_user));
	}

	/**
	 * This function synchronise dns domain record with the remote server.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param int         $id
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function addDNSRemoteRecord(string $user, string $domain, int $id): bool
	{
		return $this->client->send(new DnsRemoteRecord($user, $domain, $id));
	}

	/**
	 * This function for changing the template of records.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param string 	  $template
	 * @param bool        $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeDNSDomainTpl(string $user, string $domain, string $template, bool $restart = true): bool
	{
		return $this->client->send(new DnsDomainTpl($user, $domain, $template, $restart));
	}

	/**
	 * This function is for changing dns domain dnssec status.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param bool 	      $status
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeDNSDomainDnssec(string $user, string $domain, bool $status): bool
	{
		return $this->client->send(new DnsDomainDnssec($user, $domain, $status));
	}

	/**
	 * This function of changing the term of expiration domain's registration.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param string 	  $expiration
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeDNSDomainExp(string $user, string $domain, string $expiration): bool
	{
		return $this->client->send(new DnsDomainExp($user, $domain, $expiration));
	}

	/**
	 * This function for changing the main ip of DNS zone.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param string 	  $ip
	 * @param bool 	      $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeDNSDomainIp(string $user, string $domain, string $ip, bool $restart = true): bool
	{
		return $this->client->send(new DnsDomainIp($user, $domain, $ip, $restart));
	}

	/**
	 * This function for changing the main ip of DNS zone.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param string 	  $soa
	 * @param bool 	      $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeDNSDomainSoa(string $user, string $domain, string $soa, bool $restart = true): bool
	{
		return $this->client->send(new DnsDomainSoa($user, $domain, $soa, $restart));
	}

	/**
	 * This function for changing the time to live TTL parameter for all records.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param int 	      $ttl
	 * @param bool 	      $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function changeDNSDomainTtl(string $user, string $domain, int $ttl, bool $restart = true): bool
	{
		return $this->client->send(new DnsDomainTtl($user, $domain, $ttl, $restart));
	}

	/**
	 * This function for deleting DNS domain. By deleting it all records will also be deleted.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param bool 	      $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function deleteDNSDomain(string $user, string $domain, bool $restart = true): bool
	{
		return $this->client->send(new DnsDomainDelete($user, $domain, $restart));
	}

	/**
	 * This function for deleting all users DNS domains.
	 * 
	 * @param string 	  $user
	 * @param bool 	      $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function deleteDNSDomains(string $user, bool $restart = true): bool
	{
		return $this->client->send(new DnsDomainsDelete($user, $restart));
	}

	/**
	 * This function for deleting DNS domains related to a certain host.
	 * 
	 * @param string 	  $user
	 * @param string 	  $src
	 * @param bool 	      $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function deleteDNSDomainsSrc(string $user, string $src, bool $restart = true): bool
	{
		return $this->client->send(new DnsDomainsSrc($user, $src, $restart));
	}

	/**
	 * This function deletes dns domain or dns record based on web domain alias.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param string 	  $alias
	 * @param bool 	      $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function deleteDNSOnWebAlias(string $user, string $domain, string $alias, bool $restart = true): bool
	{
		return $this->client->send(new DeleteDnsOnWebAlias($user, $domain, $alias, $restart));
	}

	/**
	 * This function for deleting a certain record of DNS zone.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param int 	      $id
	 * @param bool 	      $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function deleteDNSRecord(string $user, string $domain, int $id, bool $restart = true): bool
	{
		return $this->client->send(new DeleteDnsRecord($user, $domain, $id, $restart));
	}

	/**
	 * This function for deleting a certain record of DNS zone.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param string 	  $key
	 * @return string
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function getDNSDomainValue(string $user, string $domain, string $key): string
	{
		return $this->client->send(new DnsDomainValue($user, $domain, $key));
	}

	/**
	 * This function inserts raw record to the dns.conf
	 * 
	 * @param string 	  $user
	 * @param string 	  $data
	 * @param string 	  $src
	 * @param bool 	      $flush
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function insertDNSDomain(string $user, string $data, string $src, bool $flush = false): bool
	{
		return $this->client->send(new InsertDnsDomain($user, $data, $src, $flush));
	}

	/**
	 * This function inserts raw dns record to the domain conf
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param string 	  $data
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function insertDNSRecord(string $user, string $domain, string $data): bool
	{
		return $this->client->send(new InsertDnsRecord($user, $domain, $data));
	}

	/**
	 * This function copy dns record to the domain conf
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param string 	  $data_file
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function insertDNSRecords(string $user, string $domain, string $data_file): bool
	{
		return $this->client->send(new InsertDnsRecords($user, $domain, $data_file));
	}

	/**
	 * This function of obtaining the list of dns domain parameters.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @return ArrayHash[]
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listDNSDomain(string $user, string $domain): ArrayHash
	{
		return $this->client->send(new ListDnsDomain($user, $domain));
	}

	/**
	 * This function of obtaining the list of dns domain parameters.
	 * 
	 * @param string 	  $user
	 * @return ArrayHash[]
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listDNSDomains(string $user): ArrayHash
	{
		return $this->client->send(new ListDnsDomains($user));
	}

	/**
	 * This function for getting all DNS domain records.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @return array
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listDNSRecords(string $user, string $domain): array
	{
		return $this->client->send(new ListDnsRecords($user, $domain));
	}

	/**
	 * This function for obtaining the DNS template parameters.
	 * 
	 * @param string 	  $template
	 * @return ArrayHash[]
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listDNSTemplate(string $template): ArrayHash
	{
		return $this->client->send(new ListDnsTemplate($template));
	}

	/**
	 * This function for obtaining the list of all DNS templates available.
	 * 
	 * @return array
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listDNSTemplates(): array
	{
		return $this->client->send(new ListDnsTemplates());
	}

	/**
	 * This function list the public key to be used with DNSSEC and needs to be added to the domain register.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param string 	  $dnstype
	 * @return ArrayHash[]
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listDNSPublicKey(string $user, string $domain, string $dnstype): ArrayHash
	{
		return $this->client->send(new DnsPublicKey($user, $domain, $dnstype));
	}

	/**
	 * This function of obtaining domain dkim dns records for proper setup.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @return ArrayHash[]
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listDNSMailDomainDkim(string $user, string $domain): ArrayHash
	{
		return $this->client->send(new DnsMailDomainDkim($user, $domain));
	}

	/**
	 * This function for obtaining the list of remote dns host.
	 * 
	 * @return ArrayHash[]
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listDNSRemoteHosts(): ArrayHash
	{
		return $this->client->send(new DnsRemoteHosts());
	}

	/**
	 * This function rebuilds DNS configuration files.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param bool 	      $restart
	 * @param bool 	      $update_serial
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function rebuildDNSDomain(string $user, string $domain, bool $restart = true, bool $update_serial = true): bool
	{
		return $this->client->send(new RebuildDnsDomain($user, $domain, $restart, $update_serial));
	}

	/**
	 * This function rebuilds DNS configuration files.
	 * 
	 * @param string 	  $user
	 * @param bool 	      $restart
	 * @param bool 	      $update_serial
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function rebuildDNSDomains(string $user, bool $restart = true, bool $update_serial = true): bool
	{
		return $this->client->send(new RebuildDnsDomains($user, $restart, $update_serial));
	}

	/**
	 * This function suspends a certain user's domain.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param bool 	      $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function suspendDNSDomain(string $user, string $domain, bool $restart = true): bool
	{
		return $this->client->send(new SuspendDnsDomain($user, $domain, $restart));
	}

	/**
	 * This function suspends all user's DNS domains.
	 * 
	 * @param string 	  $user
	 * @param bool 	      $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function suspendDNSDomains(string $user, bool $restart = true): bool
	{
		return $this->client->send(new SuspendDnsDomains($user, $restart));
	}

	/**
	 * This function suspends a certain domain record.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param int 	      $id
	 * @param bool 	      $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function suspendDNSRecord(string $user, string $domain, int $id, bool $restart = true): bool
	{
		return $this->client->send(new SuspendDnsRecord($user, $domain, $id, $restart));
	}

	/**
	 * This function unsuspends a certain user's domain.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function unsuspendDNSDomain(string $user, string $domain): bool
	{
		return $this->client->send(new UnsuspendDnsDomain($user, $domain));
	}

	/**
	 * This function unsuspends all user's DNS domains.
	 * 
	 * @param string 	  $user
	 * @param bool 	      $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function unsuspendDNSDomains(string $user, bool $restart = true): bool
	{
		return $this->client->send(new UnsuspendDnsDomains($user, $restart));
	}

	/**
	 * This function unsuspends a certain domain record.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param int 	      $id
	 * @param bool 	      $restart
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function unsuspendDNSRecord(string $user, string $domain, int $id, bool $restart = true): bool
	{
		return $this->client->send(new UnsuspendDnsRecord($user, $domain, $id, $restart));
	}

	/**
	 * This function for changing DNS record.
	 * 
	 * @param string 	  $user
	 * @param string 	  $domain
	 * @param int	      $id
	 * @param string 	  $record
	 * @param string      $rtype
	 * @param string      $dvalue
	 * @param int|null    $priority
	 * @param bool        $restart
	 * @param int	      $ttl
	 * @return bool
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function editDNSRecord(string $user, string $domain, int $id, string $record, string $type, string $value, int $priority = null, bool $restart = true, int $ttl = 7200): bool
	{
		return $this->client->send(new DnsDomainRecord($user, $domain, $id, $record, $type, $value, $priority, $restart, $ttl));
	}
}