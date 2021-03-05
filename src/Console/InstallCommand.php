<?php
/**
 *
 * @Author iwill
 * @Datetime 2021/3/4 20:54
 */

namespace Miaotiao\Config\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'miaotiao:lara-admin-config';

    protected $description = 'laravel-admin-config install';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //  迁移
        $this->call('migrate');
        //  初级播种
        $this->call('db:seed', ['--class' => \Miaotiao\Config\Database\ConfigSeeder::class]);
        // 导入配置
        $this->call('admin:import',['extension'=>'config']);

        $this->info('laravel-admin-config install success');
    }

}