<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Component\Model\Message;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\Model\Message;

class MessageComponent extends OComponent {
  public ?Message $message = null;
}
