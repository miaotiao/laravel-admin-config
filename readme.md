Config manager for laravel-admin
========================
## Installation

```
$ composer require miaotiao/config

$ php artisan vendor:publish --provider="Miaotiao\Config\ConfigServiceProvider"

$ php artisan miaotiao:lara-admin-config
```

Open `http://your-host/admin/setting`

## Usage

After add config in the panel, use `dbConfig($key)` to get value you configured.

## View
![](https://raw.githubusercontent.com/miaotiao/static/master/images/laravel-admin-config/1.png)

![](https://raw.githubusercontent.com/miaotiao/static/master/images/laravel-admin-config/2.png)

## Todo
-   使用点语法获取配置信息。

License
------------
Licensed under [The MIT License (MIT)](LICENSE).
