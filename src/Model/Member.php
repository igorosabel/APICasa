<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\DB\OModel;
use Osumi\OsumiFramework\DB\OModelGroup;
use Osumi\OsumiFramework\DB\OModelField;

class Member extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id_family',
				type: OMODEL_PK,
				incr: false,
				ref: 'family.id',
				comment: 'Id de la familia'
			),
			new OModelField(
				name: 'id_user',
				type: OMODEL_PK,
				incr: false,
				ref: 'user.id',
				comment: 'Id del usuario'
			),
			new OModelField(
				name: 'is_admin',
				type: OMODEL_BOOL,
				nullable: false,
				default: false,
				comment: 'Indica si un usuario es administrador 1 o no 0'
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
}
