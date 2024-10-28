<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\DTO;

use Osumi\OsumiFramework\Core\ODTO;
use Osumi\OsumiFramework\Web\ORequest;

class MessageDTO implements ODTO{
  public ?int $id = null;
	public ?int $id_user = null;
	public ?string $body = null;
	public ?int $type = null;
	public ?bool $done = null;
	public ?bool $is_private = null;
	public ?array $tags = null;
	public ?string $date = null;
	public ?string $color = null;
	public ?string $tag_list = null;

	public function isValid(): bool {
		return (!is_null($this->body));
	}

	public function load(ORequest $req): void {
		$filter = $req->getFilter('Login');

		$this->id         = $req->getParamInt('id');
		$this->id_user    = $filter['id'];
		$this->body       = $req->getParamString('body');
		$this->type       = $req->getParamInt('type');
		$this->done       = $req->getParamBool('done');
		$this->is_private = $req->getParamBool('is_private');
		$this->tags       = $req->getParam('tags');
		$this->date       = $req->getParamString('date');
		$this->color      = $req->getParamString('color');
		$this->tag_list   = $req->getParamString('tag_list');
	}
}
