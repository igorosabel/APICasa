<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\DTO;

use Osumi\OsumiFramework\Core\ODTO;
use Osumi\OsumiFramework\Web\ORequest;

class PassUpdateDTO implements ODTO{
	private ?string $current = null;
	private ?string $new_pass = null;
	private ?string $conf_pass = null;
	private ?int $id_token = null;

	public function getCurrent(): ?string {
		return $this->current;
	}
	private function setCurrent(?string $current): void {
		$this->current = $current;
	}
	public function getNewPass(): ?string {
		return $this->new_pass;
	}
	private function setNewPass(?string $new_pass): void {
		$this->new_pass = $new_pass;
	}
	public function getConfPass(): ?string {
		return $this->conf_pass;
	}
	private function setConfPass(?string $conf_pass): void {
		$this->conf_pass = $conf_pass;
	}
	public function getIdToken(): ?int {
		return $this->id_token;
	}
	private function setIdToken(?int $id_token): void {
		$this->id_token = $id_token;
	}

	public function isValid(): bool {
		return (
			!is_null($this->getCurrent()) &&
			!is_null($this->getNewPass()) &&
			!is_null($this->getConfPass()) &&
			($this->getNewPass() == $this->getConfPass()) &&
			!is_null($this->getIdToken())
		);
	}

	public function load(ORequest $req): void {
		$this->setCurrent($req->getParamString('current'));
		$this->setNewPass($req->getParamString('new_pass'));
		$this->setConfPass($req->getParamString('conf_pass'));
		$filter = $req->getFilter('Login');
		if ($filter['status'] != 'error') {
			$this->setIdToken($filter['id']);
		}
	}
}
