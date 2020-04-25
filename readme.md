Config manager for laravel-admin
========================
## Installation

```
$ composer require miaotiao/config

$ php artisan vendor:publish --provider="Miaotiao\Config\ConfigServiceProvider"

$ php artisan migrate

$ composer dump-autoload

$ php artisan db:seed --class=ConfigSeeder
```


Then run: 

```
$ php artisan admin:import config
```

Open `http://your-host/admin/setting`

## Usage

After add config in the panel, use `dbConfig($key)` to get value you configured.

## Todo
-   使用点语法获取配置信息。

License
------------
Licensed under [The MIT License (MIT)](LICENSE).
