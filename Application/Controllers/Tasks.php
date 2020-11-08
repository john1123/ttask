<?php

namespace Application\Controllers;

use Application\Models\Tasks as TasksModel;
use Framework\View;
use Framework\Controller;
use Framework\Session;

class Tasks extends Controller
{
    public $title = 'Задачи';
    function actionIndex()
    {
        $this->redirect('tasks', 'list');
    }
    function actionList($arParameters)
    {
        $this->title = 'Список задач';

        // постраничная навигация
        if ( array_key_exists('page', $arParameters) ) {
            Session::set('page', intval($arParameters['page']));
        }
        $pageNumber = Session::get('page', 1);
        
        // сортировка
        $sortField = Session::get('sortField', 'id');
        $sortDir = Session::get('sortDir', 'asc');
        if ( array_key_exists('sort', $arParameters) ) {
            $sortField = in_array($arParameters['sort'], ['id', 'username', 'email', 'task'])
                    ? $arParameters['sort']
                    : 'id';
            $sortSession = Session::get('sort', ($sortField . '_' . $sortDir));
                $sortSessionField = Session::get('sortField');
                $sortSessionDir = Session::get('sortDir');
                if ($sortSessionField == $sortField) {
                    $sortDir = $sortSessionDir == 'asc' ? 'desc' : 'asc';
                }
            Session::set('sortField', $sortField);
            Session::set('sortDir', $sortDir);
        }
        
        $tasksModel = new TasksModel();
        $arTasksPage = $tasksModel->getTasksPage($pageNumber, $sortField, $sortDir);
        return View::render('tasks/list.tmpl.php', [
            'tasks' => $arTasksPage,
            'tasksCount' => $tasksModel->getTasksCount(),
            'page' => $pageNumber,
            'sortField' => $sortField,
            'sortDir' => $sortDir,
        ]);
    }
    function actionEdit($id=0)
    {
        return View::render('tasks/edit.tmpl.php');
    }
}