<?php

namespace HestiaCP;

use HestiaCP\Authorization\Credentials;
use HestiaCP\Authorization\Host;
use HestiaCP\Command\Add\LetsEncryptDomain;
use HestiaCP\Command\ICommand;
use HestiaCP\Module\Backups;
use HestiaCP\Module\Databases;
use HestiaCP\Module\Mails;
use HestiaCP\Module\Module;
use HestiaCP\Module\Users;
use HestiaCP\Module\Webs;
use HestiaCP\Module\DNS;
use HestiaCP\Module\Access;
use HestiaCP\Module\System;

use PhpArrayUtils\Arr;

class Client
{

    /** @var Host */
    private $host;

    /** @var \GuzzleHttp\Client */
    private $guzzleClient;

    /** @var array */
    private $modules = [];

    /**
     * Client constructor.
     * @param Host $host
     * @param array|null $options
     * @throws ClientException
     */
    public function __construct(Host $host, array $options = null)
    {
        $this->setHost($host);
        $this->prepareCommunication($options);
    }

    /**
     * @param string $hostname Hostname
     * @param string $user Username or API Key
     * @param mixed $password Password (must be null if using API Key)
     * @return Client
     * @throws ClientException
     */
    public static function simpleFactory(string $hostname, string $user, string $password = null): Client
    {
        $credentials = new Credentials($user, $password);
        $host = new Host($hostname, $credentials);

        return new self($host);
    }

    public function setHost(Host $host)
    {
        $this->host = $host;
        return $this;
    }

    public function getHost(): Host
    {
        return $this->host;
    }

    /**
     * @param ICommand $command
     * @return mixed
     * @throws ClientException
     * @throws ProcessException
     */
    public function send(ICommand $command)
    {
        $host = $this->getHost();
        try {
            $timeout = $this->guzzleClient->getConfig('timeout');
            if ($command instanceof LetsEncryptDomain) {
                $timeout = 90;
            }
            $response = $this->guzzleClient->post($host->buildUri(), [
                'form_params' => array_merge(
                    $host->getCredentials()->getRequestParams(),
                    $command->getRequestParams(),
                    [
                        'returncode' => $command->needReturnCode() ? 'yes' : 'no',
                        'cmd' => $command->getName()
                    ]
                ),
                'verify' => false,
                'timeout' => $timeout
            ]);
            $command->setLastResponse($response);
            return $command->process();
        } catch (ProcessException $e) {
            throw $e;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $command->processException($e);
        } catch (\Exception $e) {
            throw new ClientException('Fatal processing error (' . $e->getMessage() . ')');
        }
    }

    /**
     * @param array|null $options
     * @return Client
     * @throws ClientException
     */
    private function prepareCommunication(array $options = null): Client
    {
        try {
            $this->guzzleClient = new \GuzzleHttp\Client([
                'timeout' => $options['timeout'] ?? 10.0
            ]);
        } catch (\Exception $e) {
            throw new ClientException('Bad Client configuration (' . $e->getMessage() . ')');
        }

        return $this;
    }

    static array $modulesClassMap = [
        'user' => Users::class,
        'sys' => System::class,
        'access' => Access::class,
        'dns' => DNS::class,
        'db' => Databases::class,
        'backup' => Backups::class,
        'web' => Webs::class,
        'mail' => Mails::class
    ];

    /**
     * @throws \Exception
     */
    public static function getModuleClassByName($moduleName): Module
    {
        return
            self::$modulesClassMap[$moduleName]
            ?? throw new \Exception("Missing module '{$moduleName}'");
    }

    /**
     * @throws \Exception
     */
    public function getModule($moduleName, $param = NULL): Users
    {
        $class = self::getModuleClassByName($moduleName);
        return $this->loadModule($class, $param);
    }

    private function loadModule($moduleName, $param = null)
    {
        $key = $moduleName . ($param ?? NULL);
        if (Arr::has($this->modules, $key))
            return $this->modules[$moduleName];
        if ($param !== NULL) {
            Arr::set($this->modules, $key, new $moduleName($this, $param));
        } else {
            Arr::set($this->modules, $key, new $moduleName($this));
        }
        return Arr::get($this->modules, $key);
    }

    public function getModuleUser(): Users
    {
        return $this->loadModule(Users::class);
    }

    public function getModuleMail(string $user): Mails
    {
        return $this->loadModule(Mails::class, $user);
    }

    public function getModuleWeb(string $user): Webs
    {
        return $this->loadModule(Webs::class, $user);
    }

    public function getModuleBackup(string $user): Backups
    {
        return $this->loadModule(Backups::class, $user);
    }

    public function getModuleDatabase(string $user): Databases
    {
        return $this->loadModule(Databases::class, $user);
    }

    public function getModuleDNS(): DNS
    {
        return $this->loadModule(DNS::class);
    }

    public function getModuleAccess(): Access
    {
        return $this->loadModule(Access::class);
    }

    public function getModuleSystem(): System
    {
        return $this->loadModule(System::class);
    }
}
