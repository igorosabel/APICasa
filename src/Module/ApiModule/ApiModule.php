<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule;

use Osumi\OsumiFramework\Routing\OModule;

#[OModule(
	type: 'json',
	prefix: '/api',
	actions: ['CheckPasswordToken', 'GetMessage', 'GetMessages', 'GetTags', 'GetUser', 'Login', 'NewPassword', 'Recover', 'Register', 'SaveMessage', 'UpdatePass', 'UpdateTask', 'UpdateUser']
)]
class ApiModule {}
