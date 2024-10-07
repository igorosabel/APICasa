<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\Routes;

use Osumi\OsumiFramework\Routing\ORoute;
use Osumi\OsumiFramework\App\Module\Api\CheckPasswordToken\CheckPasswordTokenAction;
use Osumi\OsumiFramework\App\Module\Api\GetMessage\GetMessageAction;
use Osumi\OsumiFramework\App\Module\Api\GetMessages\GetMessagesAction;
use Osumi\OsumiFramework\App\Module\Api\GetTags\GetTagsAction;
use Osumi\OsumiFramework\App\Module\Api\GetUser\GetUserAction;
use Osumi\OsumiFramework\App\Module\Api\Login\LoginAction;
use Osumi\OsumiFramework\App\Module\Api\NewPassword\NewPasswordAction;
use Osumi\OsumiFramework\App\Module\Api\Recover\RecoverAction;
use Osumi\OsumiFramework\App\Module\Api\Register\RegisterAction;
use Osumi\OsumiFramework\App\Module\Api\SaveMessage\SaveMessageAction;
use Osumi\OsumiFramework\App\Module\Api\UpdatePass\UpdatePassAction;
use Osumi\OsumiFramework\App\Module\Api\UpdateTask\UpdateTaskAction;
use Osumi\OsumiFramework\App\Module\Api\UpdateUser\UpdateUserAction;
use Osumi\OsumiFramework\App\Filter\LoginFilter;

ORoute::group('/api', 'json', function() {
  ORoute::post('/check-password-token', CheckPasswordTokenAction::class);
  ORoute::post('/get-message',          GetMessageAction::class,  [LoginFilter::class]);
  ORoute::post('/get-messages',         GetMessagesAction::class, [LoginFilter::class]);
  ORoute::post('/get-tags',             GetTagsAction::class,     [LoginFilter::class]);
  ORoute::post('/get-user',             GetUserAction::class,     [LoginFilter::class]);
  ORoute::post('/login',                LoginAction::class);
  ORoute::post('/new-password',         NewPasswordAction::class);
  ORoute::post('/recover',              RecoverAction::class);
  ORoute::post('/register',             RegisterAction::class);
  ORoute::post('/save-message',         SaveMessageAction::class, [LoginFilter::class]);
  ORoute::post('/update-pass',          UpdatePassAction::class,  [LoginFilter::class]);
  ORoute::post('/update-task',          UpdateTaskAction::class,  [LoginFilter::class]);
  ORoute::post('/update-user',          UpdateUserAction::class,  [LoginFilter::class]);
});
