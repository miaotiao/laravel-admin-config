<?php

namespace Miaotiao\Config;

use Illuminate\Support\ServiceProvider;
use Miaotiao\Config\Console\InstallCommand;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * 启动应用服务
     *
     * 解决数据库不存在的时候报错
     */
    public function boot()
    {
        try {
            if ($this->app->runningInConsole()) {
                $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

                $this->publishes([__DIR__.'/Database' => database_path('seeds')]);

                $this->commands([
                    InstallCommand::class,
                ]);
            }
            Config::load();
            Config::boot();
        } catch (\Exception $e) {
            //
        }
    }
}
