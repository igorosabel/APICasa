<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\DTO;

use Osumi\OsumiFramework\Core\ODTO;
use Osumi\OsumiFramework\Web\ORequest;

class UserUpdateDTO implements ODTO{
	public ?int $id = null;
	public ?string $name = null;
	public ?string $email = null;
	public ?string $color = null;
	public ?int $id_token = null;

	public function isValid(): bool {
		return (
			!is_null($this->id) &&
			!is_null($this->name) &&
			!is_null($this->email) &&
			!is_null($this->color) &&
			$this->id == $this->id_token
		);
	}

	public function load(ORequest $req): void {
		$this->id    = $req->getParamInt('id');
		$this->name  = $req->getParamString('name');
		$this->email = $req->getParamString('email');
		$this->color = $req->getParamString('color');

		$filter = $req->getFilter('Login');
		if ($filter['status'] !== 'error') {
			$this->id_token = $filter['id'];
		}
	}
}
