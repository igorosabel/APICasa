<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\Routes;

use Osumi\OsumiFramework\Routing\ORoute;
use Osumi\OsumiFramework\App\Module\Api\CheckPasswordToken\CheckPasswordTokenComponent;
use Osumi\OsumiFramework\App\Module\Api\GetMessage\GetMessageComponent;
use Osumi\OsumiFramework\App\Module\Api\GetMessages\GetMessagesComponent;
use Osumi\OsumiFramework\App\Module\Api\GetTags\GetTagsComponent;
use Osumi\OsumiFramework\App\Module\Api\GetUser\GetUserComponent;
use Osumi\OsumiFramework\App\Module\Api\Login\LoginComponent;
use Osumi\OsumiFramework\App\Module\Api\NewPassword\NewPasswordComponent;
use Osumi\OsumiFramework\App\Module\Api\Recover\RecoverComponent;
use Osumi\OsumiFramework\App\Module\Api\Register\RegisterComponent;
use Osumi\OsumiFramework\App\Module\Api\SaveMessage\SaveMessageComponent;
use Osumi\OsumiFramework\App\Module\Api\UpdatePass\UpdatePassComponent;
use Osumi\OsumiFramework\App\Module\Api\UpdateTask\UpdateTaskComponent;
use Osumi\OsumiFramework\App\Module\Api\UpdateUser\UpdateUserComponent;
use Osumi\OsumiFramework\App\Filter\LoginFilter;

ORoute::prefix('/api', function() {
  ORoute::post('/check-password-token', CheckPasswordTokenComponent::class);
  ORoute::post('/get-message',          GetMessageComponent::class,  [LoginFilter::class]);
  ORoute::post('/get-messages',         GetMessagesComponent::class, [LoginFilter::class]);
  ORoute::post('/get-tags',             GetTagsComponent::class,     [LoginFilter::class]);
  ORoute::post('/get-user',             GetUserComponent::class,     [LoginFilter::class]);
  ORoute::post('/login',                LoginComponent::class);
  ORoute::post('/new-password',         NewPasswordComponent::class);
  ORoute::post('/recover',              RecoverComponent::class);
  ORoute::post('/register',             RegisterComponent::class);
  ORoute::post('/save-message',         SaveMessageComponent::class, [LoginFilter::class]);
  ORoute::post('/update-pass',          UpdatePassComponent::class,  [LoginFilter::class]);
  ORoute::post('/update-task',          UpdateTaskComponent::class,  [LoginFilter::class]);
  ORoute::post('/update-user',          UpdateUserComponent::class,  [LoginFilter::class]);
});
