<?php declare(strict_types=1);

namespace OsumiFramework\App\DTO;

use OsumiFramework\OFW\Core\ODTO;
use OsumiFramework\OFW\Web\ORequest;

class NewPassDTO implements ODTO{
	private ?string $pass = null;
  private ?string $conf = null;
  private ?string $token = null;

	public function getPass(): ?string {
		return $this->pass;
	}
	private function setPass(?string $pass): void {
		$this->pass = $pass;
	}
  public function getConf(): ?string {
		return $this->conf;
	}
	private function setConf(?string $conf): void {
		$this->conf = $conf;
	}
  public function getToken(): ?string {
		return $this->token;
	}
	private function setToken(?string $token): void {
		$this->token = $token;
	}

	public function isValid(): bool {
		return (
      !is_null($this->getPass()) &&
      !is_null($this->getConf()) &&
      !is_null($this->getToken()) &&
      ($this->getPass() == $this->getConf())
    );
	}

	public function load(ORequest $req): void {
		$this->setPass($req->getParamString('pass'));
    $this->setConf($req->getParamString('conf'));
    $this->setToken($req->getParamString('token'));
	}
}
