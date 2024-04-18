<?php

namespace HestiaCP\Module;

use HestiaCP\Client;
use PhpArrayUtils\Arr;

abstract class Module implements IModule {

	/** @var Client */
	protected Client $client;

	public function __construct(Client $client) {
		$this->client = $client;
	}

    public static array $modulesClassMap = [
        'user' => Users::class,
        'users' => Users::class,
        'sys' => System::class,
        'system' => System::class,
        'access' => Access::class,
        'dns' => DNS::class,
        'db' => Databases::class,
        'database' => Databases::class,
        'databases' => Databases::class,
        'backup' => Backups::class,
        'backups' => Backups::class,
        'web' => Webs::class,
        'webs' => Webs::class,
        'mail' => Mails::class,
        'mails' => Mails::class
    ];

    /**
     * @throws \Exception
     */
    public static function getModuleClassName($moduleName): string
    {
        return
            self::$modulesClassMap[$moduleName]
            ?? throw new \Exception("Missing module '{$moduleName}'");
    }

    /**
     * @throws \Exception
     */
    final public static function factory($moduleName, Client $client, array $arguments = []): Module
    {
        $className = self::getModuleClassName($moduleName);
        if (!class_exists($className)) {
            throw new \Exception("Server class {$className} not exists!");
        }

        return $className::getInstance($client, $arguments);
    }

    private static function cacheKey(...$args)
    {
        return dechex(crc32(print_r($args, true)));
    }

    /**
     * @var Module[]
     */
    private static array $instances = [];

    /**
     * @param Client $client
     * @param array $arguments
     * @return Module
     */
    final public static function getInstance(Client $client, array $arguments = []): Module
    {
        $key = self::cacheKey(get_called_class(), $arguments);

        if (Arr::has(self::$instances, $key))
            return Arr::get(self::$instances, $key);

        $class = new \ReflectionClass(get_called_class());
        $instance = $class->newInstanceArgs([$client, ...$arguments]);
//        $instance = new static($client, ...$arguments);

        Arr::set(self::$instances, $key, $instance);
        return $instance;
    }
}
