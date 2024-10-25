<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Service;

use Osumi\OsumiFramework\Core\OService;
use Osumi\OsumiFramework\App\Model\User;

class UserService extends OService {
  /**
   * Función para comprobar si un inicio de sesión es correcto o no
   *
   * @param string $email Email del usuario
   *
   * @param string $pass Contraseña del usuario
   *
   * @return ?User Devuelve el usuario en caso correcto o null en caso de error
   */
  public function login(string $email, string $pass): ?User {
    $user = User::findOne(['email' => $email]);
    if (!is_null($user) && $user->checkPass($pass)) {
      return $user;
		}
		return null;
  }
}
