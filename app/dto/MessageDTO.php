<?php declare(strict_types=1);

namespace OsumiFramework\App\DTO;

use OsumiFramework\OFW\Core\ODTO;
use OsumiFramework\OFW\Web\ORequest;

class MessageDTO implements ODTO{
  private ?int $id = null;
	private ?int $id_user = null;
	private ?string $body = null;
	private ?int $type = null;
	private ?bool $done = null;
	private ?bool $is_private = null;
	private ?array $tags = null;
	private ?string $date = null;
	private ?string $color = null;
	private ?string $tag_list = null;

	public function getId(): ?int {
		return $this->id;
	}
	private function setId(?int $id): void {
		$this->id = $id;
	}
	public function getIdUser(): ?int {
		return $this->id_user;
	}
	private function setIdUser(?int $id_user): void {
		$this->id_user = $id_user;
	}
	public function getBody(): ?string {
		return $this->body;
	}
	private function setBody(?string $body): void {
		$this->body = $body;
	}
	public function getType(): ?int {
		return $this->type;
	}
	private function setType(?int $type): void {
		$this->type = $type;
	}
	public function getDone(): ?bool {
		return $this->done;
	}
	private function setDone(?bool $done): void {
		$this->done = $done;
	}
	public function getIsPrivate(): ?bool {
		return $this->is_private;
	}
	private function setIsPrivate(?bool $is_private): void {
		$this->is_private = $is_private;
	}
	public function getTags(): ?array {
		return $this->tags;
	}
	private function setTags(?array $tags): void {
		$this->tags = $tags;
	}
	public function getDate(): ?string {
		return $this->date;
	}
	private function setDate(?string $date): void {
		$this->date = $date;
	}
	public function getColor(): ?string {
		return $this->color;
	}
	private function setColor(?string $color): void {
		$this->color = $color;
	}
	public function getTagList(): ?string {
		return $this->tag_list;
	}
	private function setTagList(?string $tag_list): void {
		$this->tag_list = $tag_list;
	}

	public function isValid(): bool {
		return (!is_null($this->getBody()));
	}

	public function load(ORequest $req): void {
		$filter = $req->getFilter('loginFilter');

		$this->setId($req->getParamInt('id'));
		$this->setIdUser($filter['id']);
		$this->setBody($req->getParamString('body'));
		$this->setType($req->getParamInt('type'));
		$this->setDone($req->getParamBool('done'));
		$this->setIsPrivate($req->getParamBool('is_private'));
		$this->setTags($req->getParam('tags'));
		$this->setDate($req->getParamString('date'));
		$this->setColor($req->getParamString('color'));
		$this->setTagList($req->getParamString('tag_list'));
	}
}
