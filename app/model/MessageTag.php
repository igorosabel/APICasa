<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class MessageTag extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$table_name  = 'message_tag';
		$model = [
			'id_message' => [
				'type'    => OModel::PK,
				'incr' => false,
				'ref' => 'message.id',
				'comment' => 'Id del mensaje'
			],
			'id_tag' => [
				'type'    => OModel::PK,
				'incr' => false,
				'ref' => 'tag.id',
				'comment' => 'Id de la tag'
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
}
