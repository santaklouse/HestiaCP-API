<?php

namespace HestiaCP\Module;

use Nette\Utils\ArrayHash;
use HestiaCP\Command\Lists\AccessKeys;


class Access extends Module {

	/**
	 * This function list all API access keys.
	 * 
	 * @param string $user
	 * @return array
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listAllApiKeys(string $user): array {
		return $this->client->send(new AccessKeys($user));
	}
}
