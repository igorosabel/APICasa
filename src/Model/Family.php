<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\DB\OModel;
use Osumi\OsumiFramework\DB\OModelGroup;
use Osumi\OsumiFramework\DB\OModelField;

class Family extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id único para cada familia'
			),
			new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				nullable: false,
				size: 50,
				comment: 'Nombre de la familia'
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

	private ?array $members = null;

	/**
	 * Obtiene la lista de miembros de la familia
	 *
	 * @return array Lista de miembros
	 */
	public function getMembers(): array {
		if (is_null($this->members)) {
			$this->loadMembers();
		}
		return $this->members;
	}

	/**
	 * Guarda la lista de miembros
	 *
	 * @param array $members Lista de miembros
	 *
	 * @return void
	 */
	public function setMembers(array $members):  void {
		$this->members = $members;
	}

	/**
	 * Carga la lista de miembros
	 *
	 * @return void
	 */
	public function loadMembers(): void {
		$sql = "SELECT * FROM `user` WHERE `id` IN (SELECT `id_user` FROM `member` WHERE `id_family` = ?)";
		$this->db->query($sql, [$this->get('id')]);
		$list = [];

		while ($res = $this->db->next()) {
			$member = new User();
			$member->update($res);
			array_push($list, $member);
		}

		$this->setMembers($list);
	}
}
