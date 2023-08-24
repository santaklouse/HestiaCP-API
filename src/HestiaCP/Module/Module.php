<?php

namespace HestiaCP\Module;

use HestiaCP\Client;

abstract class Module implements IModule {

	/** @var Client */
	protected $client;

	public function __construct(Client $client) {
		$this->client = $client;
	}
}
