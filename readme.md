Config manager for laravel-admin
========================
## Installation

```
$ composer require miaotiao/config

$ php artisan vendor:publish --provider="Miaotiao\Config\ConfigServiceProvider"

$ php artisan migrate

$ php artisan db:seed --class=ConfigSeeder
```

Open `app/Providers/AppServiceProvider.php`, and call the `Config::load()` method within the `boot` method:



Then run: 

```
$ php artisan admin:import config
```

Open `http://your-host/admin/setting`

## Usage

After add config in the panel, use `dbConfig($key)` to get value you configured.

## Todo
-   判断是否使用的是 admin 的数据库配置
-   增加test测试

License
------------
Licensed under [The MIT License (MIT)](LICENSE).
