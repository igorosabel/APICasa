<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\DB\OModel;
use Osumi\OsumiFramework\DB\OModelGroup;
use Osumi\OsumiFramework\DB\OModelField;

class User extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único de cada usuario'
			),
			new OModelField(
				name: 'email',
				type: OMODEL_TEXT,
				nullable: false,
				default: 'null',
				size: 50,
				comment: 'Email del usuario'
			),
			new OModelField(
				name: 'pass',
				type: OMODEL_TEXT,
				nullable: false,
				default: 'null',
				size: 100,
				comment: 'Contraseña del usuario'
			),
			new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				nullable: false,
				default: 'null',
				size: 100,
				comment: 'Nombre del usuario'
			),
			new OModelField(
				name: 'color',
				type: OMODEL_TEXT,
				nullable: false,
				default: 'null',
				size: 6,
				comment: 'Color que identifique al usuario'
			),
			new OModelField(
				name: 'created_at',
				type: OMODEL_CREATED,
				comment: 'Fecha de creación del registro'
			),
			new OModelField(
				name: 'updated_at',
				type: OMODEL_UPDATED,
				nullable: true,
				default: null,
				comment: 'Fecha de última modificación del registro'
			)
		);

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
		$sql = "SELECT * FROM `family` WHERE `id` IN (SELECT `id_family` FROM `member` WHERE `id_user` = ?)";
		$this->db->query($sql, [$this->get('id')]);

		if ($res = $this->db->next()) {
			$family = new Family();
			$family->update($res);

			$this->setFamily($family);
		}

		$this->family_checked = true;
	}
}
