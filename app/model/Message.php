<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\App\Model\Tag;

class Message extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'message';
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id unico de cada mensaje'
			],
			'id_user' => [
				'type'    => OModel::NUM,
				'nullable' => true,
				'default' => null,
				'ref' => 'user.id',
				'comment' => 'Id del usuario que crea el mensaje'
			],
			'body' => [
				'type'    => OModel::LONGTEXT,
				'nullable' => false,
				'default' => null,
				'comment' => 'Contenido del mensaje'
			],
			'type' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => 0,
				'comment' => 'Tipo de mensaje 0 nota 1 tarea'
			],
			'done' => [
				'type'    => OModel::BOOL,
				'nullable' => false,
				'default' => null,
				'comment' => 'En caso de ser una tarea indica si esta completada 1 o no 0'
			],
			'private' => [
				'type'    => OModel::BOOL,
				'nullable' => false,
				'default' => false,
				'comment' => 'Indica si un mensaje es privado 1 o no 0'
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

		parent::load($table_name, $model);
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
}
