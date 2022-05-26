<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class User extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único de cada usuario'
			],
			'email' => [
				'type'    => OModel::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 50,
				'comment' => 'Email del usuario'
			],
			'pass' => [
				'type'    => OModel::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 100,
				'comment' => 'Contraseña del usuario'
			],
			'name' => [
				'type' => OModel::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 100,
				'comment' => 'Nombre del usuario'
			],
			'color' => [
				'type' => OModel::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 6,
				'comment' => 'Color que identifique al usuario'
			],
			'created_at' => [
				'type'    => OModel::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OModel::UPDATED,
				'nullable' => true,
				'default' => null,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($model);
	}

	/**
	 * Función para comprobar un inicio de sesión. Primero busca el usuario por su email y luego comprueba su contraseña.
	 *
	 * @param string $email Email del usuario
	 *
	 * @param string $pass Contraseña a comprobar del usuario
	 *
	 * @return bool Devuelve si el inicio de sesión es correcto
	 */
	public function login(string $email, string $pass): bool {
		if ($this->find(['email' => $email])) {
			return $this->checkPass($pass);
		}
		else {
			return false;
		}
	}

	/**
	 * Comprueba la contraseña del usuario actualmente cargado
	 *
	 * @param string $pass Contraseña a comprobar del usuario
	 *
	 * @return bool Devuelve si el inicio de sesión es correcto
	 */
	public function checkPass(string $pass): bool {
		return password_verify($pass, $this->get('pass'));
	}
}
