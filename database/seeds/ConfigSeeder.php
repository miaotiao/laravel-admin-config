<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = config('admin.extensions.config.table', 'sys_config');

        DB::table($table)->truncate();
        DB::table($table)->insert([
            [
                'name'      =>  'web_site_title',
                'title'     =>  '前台网站标题',
                'type'      =>  2,
                'group'     =>  1,
                'remark'    =>  '',
                'extra'     =>  '',
                'value'     =>  '',
            ],
            [
                'name'      =>  'web_site_description',
                'title'     =>  '前台网站描述',
                'type'      =>  3,
                'group'     =>  1,
                'remark'    =>  '',
                'extra'     =>  '',
                'value'     =>  '',
            ],
            [
                'name'      =>  'web_site_keyword',
                'title'     =>  '前台网站关键词',
                'type'      =>  2,
                'group'     =>  1,
                'remark'    =>  '',
                'extra'     =>  '',
                'value'     =>  '',
            ],
            [
                'name'      =>  'web_site_status',
                'title'     =>  '关闭前台',
                'type'      =>  5,
                'group'     =>  1,
                'remark'    =>  '',
                'extra'     =>  '0:关闭;1:开启',
                'value'     =>  '1',
            ],
            [
                'name'      =>  'web_site_icp',
                'title'     =>  '备案信息',
                'type'      =>  2,
                'group'     =>  1,
                'remark'    =>  '',
                'extra'     =>  '',
                'value'     =>  '',
            ],
            [
                'name'      =>  'sys_config_type',
                'title'     =>  '系统配置类型',
                'type'      =>  '4',
                'group'     =>  '4',
                'remark'    =>  '',
                'extra'     =>  '',
                'value'     =>  "1:数字\r\n2:字符\r\n3:文本\r\n4:数组\r\n5:枚举",
            ],
            [
                'name'      =>  'sys_config_group',
                'title'     =>  '系统配置分组',
                'type'      =>  4,
                'group'     =>  4,
                'remark'    =>  '',
                'extra'     =>  '',
                'value'     =>  "1:基本\r\n2:内容\r\n3:用户\r\n4:系统",
            ],
            [
                'name'      =>  'category_type',
                'title'     =>  '栏目类型',
                'type'      =>  4,
                'group'     =>  2,
                'remark'    =>  '',
                'extra'     =>  '',
                'value'     =>  "1:文章\r\n2:外链\r\n3:目录",
            ],
            [
                'name'      =>  'sys_debug_status',
                'title'     =>  '开发者模式',
                'type'      =>  5,
                'group'     =>  4,
                'remark'    =>  '',
                'extra'     =>  '0:否;1:是',
                'value'     =>  1,
            ],
        ]);

    }
}
