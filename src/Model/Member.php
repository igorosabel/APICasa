<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\DB\OModel;
use Osumi\OsumiFramework\DB\OModelGroup;
use Osumi\OsumiFramework\DB\OModelField;

class Member extends OModel {
	#[OPK(
		comment: 'Id de la familia',
		ref: 'family.id'
	)]
	public ?int $id_family;

	#[OPK(
		comment: 'Id del usuario',
		ref: 'user.id'
	)]
	public ?int $id_user;

	#[OField(
		comment: 'Indica si un usuario es administrador 1 o no 0',
		nullable: false,
		default: false,
	)]
	public ?bool $is_admin;

	#[OCreatedAt(
		comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
		comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
