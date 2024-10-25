<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class Invite extends OModel {
	#[OPK(
		comment: 'Id unico de cada relacion'
	)]
	public ?int $id;

	#[OField(
		comment: 'Id del usuario que manda la invitacion',
		nullable: false,
		ref: 'user.id'
	)]
	public ?int $from;

	#[OField(
		comment: 'Id del usuario al que se le manda la invitacion',
		nullable: false,
		ref: 'user.id'
	)]
	public ?int $to;

	#[OField(
		comment: 'Indica si la invitacion se ha aceptado 1 o no 0',
		nullable: false,
		default: false,
	)]
	public ?bool $accepted;

	#[OCreatedAt(
		comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
		comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
