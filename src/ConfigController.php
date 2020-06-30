<?php

namespace Miaotiao\Config;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class ConfigController
{
    use HasResourceActions;

    protected $db_config = [];

    public function __construct()
    {
        $this->clearCache();
        Config::load();
    }

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Config')
            ->description('list')
            ->body($this->grid());
    }

    /**
     * Edit interface.
     *
     * @param int     $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Config')
            ->description('edit')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Config')
            ->description('create')
            ->body($this->form());
    }

    public function show($id, Content $content)
    {
        return $content
            ->header('Config')
            ->description('detail')
            ->body(Admin::show(ConfigModel::findOrFail($id), function (Show $show) {
                $show->field('id', __('Id'));
                $show->field('name', __('Name'));
                $show->field('title', __('Title'));
                $show->field('sort', __('Sort'));
                $show->field('type', __('Type'));
                $show->field('group', __('Group'));
                $show->field('remark', __('Remark'));
                $show->field('extra', __('Extra'));
                $show->field('value', __('Value'));
                $show->field('status', __('Status'));
                $show->field('created_at', __('Created at'));
                $show->field('updated_at', __('Updated at'));
                $show->field('deleted_at', __('Deleted at'));

                return $show;
            }));
    }

    public function grid()
    {
        $grid = new Grid(new ConfigModel());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'))->editable();
        $grid->column('title', __('Title'))->editable();
        $grid->column('sort', __('Sort'))->sortable();
        $grid->column('type', __('Type'));
        $grid->column('group', __('Group'));
        $grid->column('remark', __('Remark'));
        $grid->column('value', __('Value'))->editable();
        $grid->column('extra', __('Extra'));
        $grid->column('status', __('Status'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->like('name');
            $filter->like('title');
        });

        return $grid;
    }

    public function form()
    {
        $form = new Form(new ConfigModel());

        $form->display('id', __('ID'));
        $form->text('name', __('Name'))->rules('required');
        $form->text('title', __('Title'));
        $form->number('sort', __('Sort'))->default(1);
        $form->select('type', __('Type'))->options(dbConfig('sys_config_type'));
        $form->select('group', __('Group'))->options(dbConfig('sys_config_group'));
        $form->text('remark', __('Remark'));
        $form->text('extra', __('Extra'));
        $form->textarea('value', __('Value'));
        $form->number('status', __('Status'))->default(1);

        $form->saved(function () {
            $this->clearCache();
        });

        return $form;
    }

    public function settingForm(Content $content)
    {
        $lists = ConfigModel::all();
        $groupArr = dbConfig('sys_config_group');

        $groups = $lists->groupBy('group')->sortBy('sort desc');

        $form = new Form(new ConfigModel());

        foreach ($groups as $key => $val) {
            $form->tab($groupArr[$key], function ($form) use ($val) {
                foreach ($val as $config) {
                    $name = $config->name;
                    $title = $config->title;
                    $value = $config->value;
                    $remark = $config->remark;
                    switch ($config->type) {
                        case '1':
                            $formObj = $form->number($name, $title);
                            break;
                        case '3':
                        case '4':
                            $formObj = $form->textarea($name, $title)->rows(3);
                            break;
                        case '5':
                            $option = parse_config_attr($config->extra,5);
                            $formObj = $form->radio($name, $title)->options($option);
                            break;
                        case '6':
                            $formObj = $form->datetime($name, $title)->format('YYYY-MM-DD HH:mm:ss');
                            break;
                        default:
                            $formObj = $form->text($name, $title);
                            break;
                    }
                    if (!empty($remark)) {
                        $formObj = $formObj->help($remark);
                    }
                    $formObj->default($value);
                }
            });
        }

        $form->setTitle(trans('admin.edit'));
        $form->setAction('/admin/system/setting/save');
        $form->tools(function (Form\Tools $tools) {
            $tools->disableList();
        });
        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        $form->saved(function (Form $form) {
            $this->clearCache();
        });

        return $content->title('网站设置')->body($form);
    }

    /**
     * 保存配置.
     *
     * @param Request $request
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function settingSave(Request $request)
    {
        $input = $request->except('_token');
        foreach ($input as $key => $conf) {
            $config = ConfigModel::where('name', $key)->firstOrFail();
            $config->value = $conf ?? '';
            $config->save();
        }
        $this->clearCache();
        admin_toastr(__('admin.save_succeeded'), 'success');

        return back();
    }

    private function clearCache()
    {
        cache()->forget('cache_db_config');
    }
}
