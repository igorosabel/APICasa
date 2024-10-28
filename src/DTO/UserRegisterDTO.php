<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\DTO;

use Osumi\OsumiFramework\Core\ODTO;
use Osumi\OsumiFramework\Web\ORequest;

class UserRegisterDTO implements ODTO{
	public ?string $email = null;
	public ?string $pass = null;
	public ?string $name = null;

	public function isValid(): bool {
		return (
			!is_null($this->email) &&
			!is_null($this->pass) &&
			!is_null($this->name)
		);
	}

	public function load(ORequest $req): void {
		$this->email = $req->getParamString('email');
		$this->pass  = $req->getParamString('pass');
		$this->name  = $req->getParamString('name');
	}
}
