<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\DTO;

use Osumi\OsumiFramework\Core\ODTO;
use Osumi\OsumiFramework\Web\ORequest;

class PassUpdateDTO implements ODTO{
	public ?string $current = null;
	public ?string $new_pass = null;
	public ?string $conf_pass = null;
	public ?int $id_token = null;

	public function isValid(): bool {
		return (
			!is_null($this->current) &&
			!is_null($this->new_pass) &&
			!is_null($this->conf_pass) &&
			($this->new_pass == $this->conf_pass) &&
			!is_null($this->id_token)
		);
	}

	public function load(ORequest $req): void {
		$this->current = $req->getParamString('current');
		$this->new_pass = $req->getParamString('new_pass');
		$this->conf_pass = $req->getParamString('conf_pass');
		$filter = $req->getFilter('Login');
		if ($filter['status'] !== 'error') {
			$this->id_token = $filter['id'];
		}
	}
}
