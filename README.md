## 目录

- [安装](#%E5%AE%89%E8%A3%85)
- [使用说明](#%E4%BD%BF%E7%94%A8%E8%AF%B4%E6%98%8E)
	- [trait介绍](#trait%E4%BB%8B%E7%BB%8D)
	    - [InstanceTrait.php](#instancetraitphp)
	    - [OverwriteCommandTrait.php](#overwritecommandtraitphp)
	    - [RedisHandlerTrait.php](#redishandlertraitphp)
	- [工具类介绍](#%E5%B7%A5%E5%85%B7%E7%B1%BB%E4%BB%8B%E7%BB%8D)
	    - [BeautifyTime.php](#beautifytimephp)
	    - [Collection.php](#collectionphp)
	    - [DbHelper.php](#dbhelperphp)
	    - [FileSize.php](#filesizephp)
	    - [Log.php](#logphp)
	    - [RequestClient.php](#requestclientphp)

## 安装

使用以下命令安装：
```
composer require jmhc/laravel-support
```

## 使用说明

### trait介绍

#### InstanceTrait.php

> `Jmhc\Support\Traits\InstanceTrait`
>
> 单例类 trait

```php
// 无构造参数使用
T::getInstance()->a();

// 有构造参数使用，c为构造参数名称
T::getInstance([
    'c' => ['a']
])->a();
```

#### OverwriteCommandTrait.php

> `Jmhc\Support\Traits\OverwriteCommandTrait`
>
> 覆盖命令行参数解析

```php
// 使用 Trait 会将 App/User 转换成 App\User
 php artisan test --class="App/User"
 ```

#### RedisHandlerTrait.php

> `Jmhc\Support\Traits\RedisHandlerTrait`
>
> redis 操作句柄 trait

### 工具类介绍

#### BeautifyTime.php

> `Jmhc\Support\Utils\Collection`
>
> 美化时间格式

#### Collection.php

> `Jmhc\Support\Utils\Collection`
>
> 集合，基于 `Illuminate\Support\Collection`

- 修改`__get` 魔术方法
- 新增`__set` , `__isset` , `__unset` 魔术方法

#### DbHelper.php

> `Jmhc\Support\Utils\DbHelper`
>
> 数据库辅助方法

```php
// 返回所有表名
DbHelper::getInstance()->getAllTables();

// 返回 mysql 链接下 users 表字段数据
DbHelper::getInstance([
    'name' => 'mysql'
])->getAllColumns('users');
```

#### FileSize.php

> `Jmhc\Support\Utils\FileSize`
>
> 转换文件尺寸

```php
// 返回 2097152 字节
FileSize::get('2m');

// 返回 2147483648 字节
FileSize::get('2g');
```

#### Log.php

> `Jmhc\Support\Utils\Log`
>
> 文件日志保存

- `debug` 日志受环境变量 `LOG_DEBUG` 控制

#### RequestClient.php

> `Jmhc\Support\Utils\RequestClient`
>
> 请求客户端，基于 `GuzzleHttp\Client`

复写构造函数：

- 设置不验证 `https`
- 设置 `user-agent` 为谷歌浏览器
