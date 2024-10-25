<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class Tag extends OModel {
	#[OPK(
		comment: 'Id único para cada familia'
	)]
	public ?int $id;

	#[OField(
		comment: 'Id del usuario que crea la tag',
		nullable: true,
		default: null,
		ref: 'user.id'
	)]
	public ?int $id_user;

	#[OField(
		comment: 'Texto de la tag',
		nullable: false,
		max: 50
	)]
	public ?string $name;

	#[OField(
		comment: 'Slug del texto de la tag',
		nullable: false,
		max: 50
	)]
	public ?string $slug;

	#[OCreatedAt(
		comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
		comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
