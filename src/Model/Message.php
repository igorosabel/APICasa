<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\DB\OModel;
use Osumi\OsumiFramework\DB\OModelGroup;
use Osumi\OsumiFramework\DB\OModelField;
use Osumi\OsumiFramework\App\Model\Tag;

class Message extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Id unico de cada mensaje'
			),
			new OModelField(
				name: 'id_user',
				type: OMODEL_NUM,
				nullable: true,
				default: null,
				ref: 'user.id',
				comment: 'Id del usuario que crea el mensaje'
			),
			new OModelField(
				name: 'body',
				type: OMODEL_LONGTEXT,
				nullable: false,
				default: 'null',
				comment: 'Contenido del mensaje'
			),
			new OModelField(
				name: 'type',
				type: OMODEL_NUM,
				nullable: false,
				default: 0,
				comment: 'Tipo de mensaje 0 nota 1 tarea'
			),
			new OModelField(
				name: 'done',
				type: OMODEL_BOOL,
				nullable: false,
				default: null,
				comment: 'En caso de ser una tarea indica si esta completada 1 o no 0'
			),
			new OModelField(
				name: 'is_private',
				type: OMODEL_BOOL,
				nullable: false,
				default: false,
				comment: 'Indica si un mensaje es privado 1 o no 0'
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
		$sql = "SELECT * FROM `tag` WHERE `id` IN (SELECT `id_tag` FROM `message_tag` WHERE `id_message` = ?)";
		$this->db->query($sql, [$this->get('id')]);
		$list = [];

		while ($res = $this->db->next()) {
			$tag = new Tag();
			$tag->update($res);
			array_push($list, $tag);
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
			array_push($tags, $tag->get('name'));
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
