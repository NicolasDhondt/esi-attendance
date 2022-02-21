<?php

namespace App\Admin\Controllers;

use App\Models\Group;
use App\Models\Student;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StudentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Students';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Student());

        $grid->column('studentId', __('Matricule'));
        $grid->column('firstName', __('Prénom'));
        $grid->column('lastName', __('Nom de famille'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Student::findOrFail($id));

        $show->field('studentId', __('Matricule'));
        $show->field('firstName', __('Prénom'));
        $show->field('lastName', __('Nom de famille'));
        $show->groups('Groups',function($group){
            $group->acronym();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Student());
        $form->text('studentId',__('Matricule'));
        $form->text('firstName', __('Prénom'));
        $form->text('lastName', __('Nom de famille'));
        $form->multipleSelect('Groups','Group')->options(Group::all()->pluck('acronym'))->attribute(['name'=>'groupSelect']);
        return $form;
    }
}
