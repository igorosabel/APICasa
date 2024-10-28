<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\DTO;

use Osumi\OsumiFramework\Core\ODTO;
use Osumi\OsumiFramework\Web\ORequest;

class NewPassDTO implements ODTO{
	public ?string $pass = null;
  public ?string $conf = null;
  public ?string $token = null;

	public function isValid(): bool {
		return (
      !is_null($this->pass) &&
      !is_null($this->conf) &&
      !is_null($this->token) &&
      ($this->pass == $this->conf)
    );
	}

	public function load(ORequest $req): void {
		$this->pass  = $req->getParamString('pass');
    $this->conf  = $req->getParamString('conf');
    $this->token = $req->getParamString('token');
	}
}
