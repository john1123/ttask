<?php

namespace Application\Controllers;

use Application\Models\Tasks as TasksModel;
use Framework\View;
use Framework\Controller;

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
        $pageNumber = array_key_exists('page', $arParameters) ? intval($arParameters['page']) : 1;
        $tasksModel = new TasksModel();
        $arTasksPage = $tasksModel->getTasksPage($pageNumber);
        return View::render('tasks/list.tmpl.php', [
            'tasks' => $arTasksPage,
            'tasksCount' => $tasksModel->getTasksCount(),
            'page' => $pageNumber,
        ]);
    }
    function actionEdit($id=0)
    {
        return View::render('tasks/edit.tmpl.php');
    }
}