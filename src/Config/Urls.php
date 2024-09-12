<?php declare(strict_types=1);

use Osumi\OsumiFramework\Routing\OUrl;
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
use Osumi\OsumiFramework\App\Module\Home\Index\IndexAction;
use Osumi\OsumiFramework\App\Module\Home\NotFound\NotFoundAction;

use Osumi\OsumiFramework\App\Filter\LoginFilter;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Service\EmailService;

$api_urls = [
  [
    'url' => '/check-password-token',
    'action' => CheckPasswordTokenAction::class,
    'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/get-message',
    'action' => GetMessageAction::class,
    'filters' => [LoginFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/get-messages',
    'action' => GetMessagesAction::class,
    'filters' => [LoginFilter::class],
    'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/get-tags',
    'action' => GetTagsAction::class,
    'filters' => [LoginFilter::class],
    'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/get-user',
    'action' => GetUserAction::class,
    'filters' => [LoginFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/login',
    'action' => LoginAction::class,
    'type' => 'json'
  ],
  [
    'url' => '/new-password',
    'action' => NewPasswordAction::class,
    'services' => [
      WebService::class,
      EmailService::class
    ],
    'type' => 'json'
  ],
  [
    'url' => '/recover',
    'action' => RecoverAction::class,
    'services' => [EmailService::class],
    'type' => 'json'
  ],
  [
    'url' => '/register',
    'action' => RegisterAction::class,
    'type' => 'json'
  ],
  [
    'url' => '/save-message',
    'action' => SaveMessageAction::class,
    'filters' => [LoginFilter::class],
    'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/update-pass',
    'action' => UpdatePassAction::class,
    'filters' => [LoginFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/update-task',
    'action' => UpdateTaskAction::class,
    'filters' => [LoginFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/update-user',
    'action' => UpdateUserAction::class,
    'filters' => [LoginFilter::class],
    'type' => 'json'
  ],
];

$home_urls = [
  [
    'url' => '/',
    'action' => IndexAction::class
  ],
  [
    'url' => '/not-found',
    'action' => NotFoundAction::class
  ],
];

$urls = [];
OUrl::addUrls($urls, $api_urls, '/api');
OUrl::addUrls($urls, $home_urls);

return $urls;
