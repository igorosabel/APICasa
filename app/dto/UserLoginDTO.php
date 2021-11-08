<?php declare(strict_types=1);

namespace OsumiFramework\App\DTO;

use OsumiFramework\OFW\Core\ODTO;
use OsumiFramework\OFW\Web\ORequest;

class UserLoginDTO implements ODTO{
	private ?string $email = null;
	private ?string $pass = null;

	public function getEmail(): ?string {
		return $this->email;
	}
	private function setEmail(?string $email): void {
		$this->email = $email;
	}
	public function getPass(): ?string {
		return $this->pass;
	}
	private function setPass(?string $pass): void {
		$this->pass = $pass;
	}

	public function isValid(): bool {
		return (!is_null($this->getEmail()) && !is_null($this->getPass()));
	}

	public function load(ORequest $req): void {
		$this->setEmail($req->getParamString('email'));
		$this->setPass($req->getParamString('pass'));
	}
}
