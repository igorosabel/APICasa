<?php declare(strict_types=1);

namespace OsumiFramework\App\Filter;

use OsumiFramework\OFW\Plugins\OToken;

/**
 * Filtro de seguridad para comprobar inicios de sesión
 *
 * @param array $params Parameter array received on the call
 *
 * @param array $headers HTTP header array received on the call
 *
 * @return array Return filter status (ok / error) and information
 */
function gameFilter(array $params, array $headers): array {
	global $core;
	$ret = ['status'=>'error', 'id'=>null];

	$tk = new OToken($core->config->getExtra('secret'));
	if ($tk->checkToken($headers['Authorization'])){
		$ret['status'] = 'ok';
		$ret['id'] = $tk->getParam('id');
	}

	return $ret;
}