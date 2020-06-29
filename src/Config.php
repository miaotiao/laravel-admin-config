<?php

namespace Miaotiao\Config;

use Encore\Admin\Admin;
use Encore\Admin\Extension;

class Config extends Extension
{
    public static function load()
    {
        $cacheDbConfig = cache()->remember('cache_db_config', 86400, function () {
            $configs = ConfigModel::where('status', 1)->get();
            $systemConf = [];
            foreach ($configs as $config) {
                $configVal = $config->value;
                if (($config->type == '4') && (!empty($configVal))) {
                    $configVal = parse_config_attr($configVal);
                }
                $systemConf[$config->name] = $configVal;
            }

            return $systemConf;
        });
        config(['dbConfig' => $cacheDbConfig]);
    }

    /**
     * Bootstrap this package.
     *
     * @return void
     */
    public static function boot()
    {
        static::registerRoutes();
        Admin::extend('config', __CLASS__);
    }

    /**
     * Register routes for laravel-admin.
     *
     * @return void
     */
    protected static function registerRoutes()
    {
        parent::routes(function ($router) {
            $configControllerPath = config('admin.extensions.config.controller', 'Miaotiao\Config\ConfigController');
            $router->resource(
                config('admin.extensions.config.name', 'config'),
                $configControllerPath
            );
            $router->get('system/setting', $configControllerPath.'@settingForm')->name('admin.configSetting');
            $router->post('system/setting/save', $configControllerPath.'@settingSave');
        });
    }

    /**
     * {@inheritdoc}
     */
    public static function import()
    {
        parent::createMenu('Setting', 'system/setting', 'fa-toggle-on');
        parent::createMenu('Config', 'config', 'fa-toggle-on', 2);
        parent::createPermission('Admin Config', 'ext.config', 'config*');
    }
}
