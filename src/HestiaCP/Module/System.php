<?php

namespace HestiaCP\Module;

use Nette\Utils\ArrayHash;
use HestiaCP\Command\Lists\SysConfig;

class System extends Module {
    /**
	 * This function for obtaining the list of system parameters.
	 * 
	 * @return array
	 * @throws \HestiaCP\ClientException
	 * @throws \HestiaCP\ProcessException
	 */
	public function listSysConfig(): array {
		return $this->client->send(new SysConfig);
	}
}
