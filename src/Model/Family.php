<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\ORM\ODB;

class Family extends OModel {
	#[OPK(
		comment: 'Id único para cada familia'
	)]
	public ?int $id;

	#[OField(
		comment: 'Nombre de la familia',
		max: 50,
		nullable: false
	)]
	public ?string $name;

	#[OCreatedAt(
		comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
		comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

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
		$db = new ODB();
		$sql = "SELECT * FROM `user` WHERE `id` IN (SELECT `id_user` FROM `member` WHERE `id_family` = ?)";
		$this->db->query($sql, [$this->get('id')]);
		$list = [];

		while ($res = $this->db->next()) {
			$member = new User($res);
			$list[] = $member;
		}

		$this->setMembers($list);
	}
}
