<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class MessageTag extends OModel {
	#[OPK(
		comment: 'Id del mensaje',
		ref: 'message.id'
	)]
	public ?int $id_message;

	#[OPK(
		comment: 'Id de la tag',
		ref: 'tag.id'
	)]
	public ?int $id_tag;

	#[OCreatedAt(
		comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
		comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
