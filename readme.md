# Mini-Program

> 文档未完善，仅本人开发使用。

因为在微信小程序中经常能够使用到的，用 `code` 获取用户 `openid` 并且使用它来获取 `passport` 中的 `access_token` 给后面的 `api` 调用提供可靠的安全性。

这些步骤有时候写起来是非常麻烦的。所以我有了一个想法，能不能把这个写成一个包方便控制。

这是我第一个包。

## 安装

首先，安装 laravel 5.5，并保证数据库正常链接。并且正常安装 `laravel/passport`

```shell
composer require m809745357/mini-program
```

在 `config/app.php` 文件中添加一下代码：

```php
/*
 * Package Service Providers...
 */
M809745357\MiniProgram\MiniProgramServiceProvider::class,
```

然后运行这些命令来发布 `migrations` 和 `config`：

```shell
php artisan vendor:publish --provider="M809745357\MiniProgram\MiniProgramServiceProvider"
```

运行以后，你可以在 `miniprogram` 里面修改看到：

```php
return [
    'program' => [
        'appid' => env('MINI_PROGRAM_APP_ID', 'miniprogramappid'),
        'appsecret' => env('MINI_PROGRAM_APP_SECRET', 'miniprogramappsecret')
    ]
];
```

需要在 `.env` 文件中配置

```
MINI_PROGRAM_APP_ID=wx947e651******
MINI_PROGRAM_APP_SECRET=59d41101e4d************
```

运行数据库迁移

```shell
php artisan migrate
```

在 `app/Providers/AuthServiceProvider.php` 中添加代码：

```php
/**
 * Register any authentication / authorization services.
 *
 * @return void
 */
public function boot()
{
    $this->registerPolicies();
  
    MiniProgram::routes();
}
```

执行 `php artisan route:list` 可以看到以下信息：

```shell
|        | POST      | api/v1/register                          |                     | \M809745357\MiniProgram\Http\Controllers\UserController@register           | api          |
|        | PUT       | api/v1/user                              |                     | \M809745357\MiniProgram\Http\Controllers\UserController@update             | api,auth:api |
```
