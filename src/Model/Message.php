<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\ORM\ODB;

class Message extends OModel {
	#[OPK(
		comment: 'Id unico de cada mensaje'
	)]
	public ?int $id;

	#[OField(
		comment: 'Id del usuario que crea el mensaje',
		nullable: true,
		default: null,
		ref: 'user.id'
	)]
	public ?int $id_user;

	#[OField(
		comment: 'Contenido del mensaje',
		type: OField::LONGTEXT,
		nullable: false
	)]
	public ?string $body;

	#[OField(
		comment: 'Tipo de mensaje 0 nota 1 tarea',
		nullable: false,
		default: 0
	)]
	public ?int $type;

	#[OField(
		comment: 'En caso de ser una tarea indica si esta completada 1 o no 0',
		nullable: false,
		default: false
	)]
	public ?bool $done;

	#[OField(
		comment: 'Indica si un mensaje es privado 1 o no 0',
		nullable: false,
		default: false
	)]
	public ?bool $is_private;

	#[OCreatedAt(
		comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
		comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

	private ?array $tags = null;

	/**
	 * Obtiene la lista de tags del mensaje
	 *
	 * @return array Lista de tags
	 */
	public function getTags(): array {
		if (is_null($this->tags)) {
			$this->loadTags();
		}
		return $this->tags;
	}

	/**
	 * Guarda la lista de tags
	 *
	 * @param array $tags Lista de tags
	 *
	 * @return void
	 */
	public function setTags(array $tags):  void {
		$this->tags = $tags;
	}

	/**
	 * Carga la lista de tags
	 *
	 * @return void
	 */
	public function loadTags(): void {
		$db = new ODB();
		$sql = "SELECT * FROM `tag` WHERE `id` IN (SELECT `id_tag` FROM `message_tag` WHERE `id_message` = ?)";
		$db->query($sql, [$this->get('id')]);
		$list = [];

		while ($res = $db->next()) {
			$tag = new Tag($res);
			$list[] = $tag;
		}

		$this->setTags($list);
	}

	/**
	 * Obtiene la lista de tags como una cadena de texto
	 *
	 * @return string Lista de tags como una cadena de texto
	 */
	public function getTagsAsString(): string {
		$list = $this->getTags();
		$tags = [];
		foreach ($list as $tag) {
			$tags[] = $tag->name;
		}

		return implode(', ', $tags);
	}

	private ?string $color = null;

	/**
	 * Obtiene el color del mensaje
	 *
	 * @return string Color del mensaje
	 */
	public function getColor(): ?string {
		return $this->color;
	}

	/**
	 * Guarda el color del mensaje
	 *
	 * @param string $color Color del mensaje
	 *
	 * @return void
	 */
	public function setColor(string $color):  void {
		$this->color = $color;
	}
}
