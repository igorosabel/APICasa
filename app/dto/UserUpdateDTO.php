<?php declare(strict_types=1);

namespace OsumiFramework\App\DTO;

use OsumiFramework\OFW\Core\ODTO;
use OsumiFramework\OFW\Web\ORequest;

class UserUpdateDTO implements ODTO{
	private ?int $id = null;
	private ?string $name = null;
	private ?string $email = null;
	private ?string $color = null;
	private ?int $id_token = null;

	public function getId(): ?int {
		return $this->id;
	}
	private function setId(?int $id): void {
		$this->id = $id;
	}
	public function getName(): ?string {
		return $this->name;
	}
	private function setName(?string $name): void {
		$this->name = $name;
	}
	public function getEmail(): ?string {
		return $this->email;
	}
	private function setEmail(?string $email): void {
		$this->email = $email;
	}
	public function getColor(): ?string {
		return $this->color;
	}
	private function setColor(?string $color): void {
		$this->color = $color;
	}
	public function getIdToken(): ?int {
		return $this->id_token;
	}
	private function setIdToken(?int $id_token): void {
		$this->id_token = $id_token;
	}

	public function isValid(): bool {
		return (
			!is_null($this->getId()) &&
			!is_null($this->getName()) &&
			!is_null($this->getEmail()) &&
			!is_null($this->getColor()) &&
			$this->getId() == $this->getIdToken()
		);
	}

	public function load(ORequest $req): void {
		$this->setId($req->getParamInt('id'));
		$this->setName($req->getParamString('name'));
		$this->setEmail($req->getParamString('email'));
		$this->setColor($req->getParamString('color'));
		$filter = $req->getFilter('loginFilter');
		if ($filter['status'] != 'error') {
			$this->setIdToken($filter['id']);
		}
	}
}
