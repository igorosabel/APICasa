<?php declare(strict_types=1);

namespace OsumiFramework\App\Module;

use OsumiFramework\OFW\Routing\OModule;

#[OModule(
	actions: 'checkPasswordToken, getMessage, getMessages, getTags, getUser, login, newPassword, recover, register, saveMessage, updatePass, updateTask, updateUser',
	type: 'json',
	prefix: '/api'
)]
class apiModule {}
