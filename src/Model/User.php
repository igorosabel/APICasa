<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\ORM\ODB;

class User extends OModel {
	#[OPK(
		comment: 'Id único de cada usuario'
	)]
	public ?int $id;

	#[OField(
		comment: 'Email del usuario',
		nullable: false,
		max: 50
	)]
	public ?string $email;

	#[OField(
		comment: 'Contraseña del usuario',
		nullable: false,
		max: 100
	)]
	public ?string $pass;

	#[OField(
		comment: 'Nombre del usuario',
		nullable: false,
		max: 100
	)]
	public ?string $name;

	#[OField(
		comment: 'Color que identifique al usuario',
		nullable: false,
		max: 6
	)]
	public ?string $color;

	#[OCreatedAt(
		comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
		comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

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

	private ?Family $family = null;
	private bool $family_checked = false;

	/**
	 * Obtiene la familia a la que pertenece un usuario
	 *
	 * @return Family Familia a la que pertenece el usuario
	 */
	public function getFamily(): ?Family {
		if (!$this->family_checked) {
			$this->loadFamily();
		}
		return $this->family;
	}

	/**
	 * Guarda la familia del usuario
	 *
	 * @param Family $family Familia del usuario
	 *
	 * @return void
	 */
	public function setFamily(Family $family):  void {
		$this->family = $family;
	}

	/**
	 * Carga la familia del usuario
	 *
	 * @return void
	 */
	public function loadFamily(): void {
		$db = new ODB();
		$sql = "SELECT * FROM `family` WHERE `id` IN (SELECT `id_family` FROM `member` WHERE `id_user` = ?)";
		$db->query($sql, [$this->id]);

		if ($res = $db->next()) {
			$family = new Family($res);
			$this->setFamily($family);
		}

		$this->family_checked = true;
	}
}
