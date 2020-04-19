<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $table = config('admin.extensions.config.table', 'sys_config');

        Schema::connection($connection)->create($table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->default('')->comment('标识符')->unique();
            $table->string('title', 250)->default('')->comment('配置名称');
            $table->string('remark', 100)->nullable()->comment('配置说明');
            $table->smallInteger('sort')->default(1)->comment('排序');
            $table->unsignedTinyInteger('type')->default(0)->comment('配置类型');
            $table->unsignedTinyInteger('group')->default(0)->comment('配置分组')->index();
            $table->text('value')->nullable()->comment('配置值');
            $table->string('extra', 255)->nullable()->comment('额外配置值');
            $table->tinyInteger('status')->default(1)->comment('状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $table = config('admin.extensions.config.table', 'admin_config');

        Schema::connection($connection)->dropIfExists($table);
    }
}
