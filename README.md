## 目录

- [安装](#%E5%AE%89%E8%A3%85)
- [使用说明](#%E4%BD%BF%E7%94%A8%E8%AF%B4%E6%98%8E)
	- [辅助类介绍](#%E8%BE%85%E5%8A%A9%E7%B1%BB%E4%BB%8B%E7%BB%8D)
	    - [DBHelper.php](#dbhelperphp)
	    - [RedisConnectionHelper.php](#redisconnectionhelperphp)
	    - [RedisHelper.php](#redishelperphp)
	- [trait介绍](#trait%E4%BB%8B%E7%BB%8D)
	    - [InstanceTrait.php](#instancetraitphp)
	    - [OverwriteCommandTrait.php](#overwritecommandtraitphp)
	- [工具类介绍](#%E5%B7%A5%E5%85%B7%E7%B1%BB%E4%BB%8B%E7%BB%8D)
	    - [BeautifyTime.php](#beautifytimephp)
	    - [Collection.php](#collectionphp)
	    - [Helper.php](#helperphp)
	    - [RequestClient.php](#requestclientphp)
	    - [RequestInfo.php](#requestinfophp)
	    - [StorageUnitConversion.php](#storageunitconversionphp)

## 安装

使用以下命令安装：
```
composer require jmhc/laravel-support
```

## 使用说明

### 辅助类介绍

#### DBHelper.php

> `Jmhc\Support\Helper\DBHelper`
>
> 数据库辅助类

```php
// 返回所有表名
DBHelper::getInstance()->getAllTables();

// 返回 mysql 链接下 users 表字段数据
DBHelper::getInstance([
    'name' => 'mysql'
])->getAllColumns('users');
```

#### RedisConnectionHelper.php

> `Jmhc\Support\Helper\RedisConnectionHelper`
>
> Redis链接辅助类

```php
// 获取默认 redis 链接
RedisConnectionHelper::get();
// 获取默认无前缀 redis 链接
RedisConnectionHelper::getNoPrefix();
// 获取 phpredis 驱动的链接
RedisConnectionHelper::getPhpRedis();
// 获取无前缀 phpredis 驱动的链接
RedisConnectionHelper::getPhpRedisNoPrefix();
```

#### RedisHelper.php

> `Jmhc\Support\Helper\RedisHelper`
>
> Redis辅助类

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

### 工具类介绍

#### BeautifyTime.php

> `Jmhc\Support\Utils\BeautifyTime`
>
> 美化时间格式

#### Collection.php

> `Jmhc\Support\Utils\Collection`
>
> 集合，基于 `Illuminate\Support\Collection`

- 修改`__get` 魔术方法
- 新增`__set` , `__isset` , `__unset` 魔术方法

#### Helper.php

> `Jmhc\Support\Utils\Helper`
>
> 辅助方法类

#### RequestClient.php

> `Jmhc\Support\Utils\RequestClient`
>
> 请求客户端，基于 `GuzzleHttp\Client`

复写构造函数：

- 设置不验证 `https`
- 设置 `user-agent` 为谷歌浏览器

#### RequestInfo.php

> `Jmhc\Support\Utils\RequestInfo`
>
> 请求信息类

#### StorageUnitConversion.php

> `Jmhc\Support\Utils\StorageUnitConversion`
>
> 储存单位转换类
