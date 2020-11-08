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
    function actionEdit($arParameters)
    {
        $tasksModel = new TasksModel();
        $taskId = array_key_exists('id', $arParameters) ? intval($arParameters['id']) : 0;
        $username = array_key_exists('username', $arParameters) ? $arParameters['username'] : '';
        if (strlen($username) > 0) {
            if ($taskId > 0 && !Session::issetVariable('user')) {
                $this->alert('Не достаточно прав', 'danger');
                $this->redirect('tasks', 'list');
            }
            
            $username = preg_replace('/\W/', '', $username);
            $username = substr($username, 0, 32);

            $email = array_key_exists('email', $arParameters) ? $arParameters['email'] : '';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
                $this->alert('Ошибка в адресе E-mail', 'danger');
                $this->redirect('tasks', 'list');
            }
            
            $task = array_key_exists('task', $arParameters) ? $arParameters['task'] : '';
            $task = htmlentities($task);
            
            $tasksModel->save([
                'id' => $taskId,
                'username' => $username,
                'email' => $email,
                'task' => $task,
                'done' => array_key_exists('done', $arParameters) ? $arParameters['done'] : '',
            ]);
            $this->alert('Задача сохранена');
            $this->redirect('tasks', 'list');
        }
        // Вывод формы
        $arTask = [];
        $this->title = 'Создать задачу';
        if ( $taskId > 0 ) {
            $taskId = intval($arParameters['id']);
            $this->title = 'Редактировать задачу';
            $arTask = $tasksModel->get($taskId);
            if (!is_array($arTask)) {
                $arTask = [];
            }
        }
        return View::render('tasks/edit.tmpl.php', [
            'id' => $taskId, 
            'username' => array_key_exists('username', $arTask) ? $arTask['username'] : '', 
            'email' => array_key_exists('email', $arTask) ? $arTask['email'] : '', 
            'task' => array_key_exists('task', $arTask) ? $arTask['task'] : '', 
            'done' => array_key_exists('done', $arTask) ? $arTask['done'] : '', 
        ]);
    }
    function actionDelete($arParameters)
    {
        if (!Session::issetVariable('user')) {
            $this->alert('Не достаточно прав', 'danger');
            $this->redirect('tasks', 'list');
        }
        
        $taskId = array_key_exists('id', $arParameters) ? intval($arParameters['id']) : 0;
        if ( $taskId > 0 ) {
            $tasksModel = new TasksModel();
            $tasksModel->delete($taskId);
            $this->alert('Задача успешно удалена');
        } else {
            $this->alert('Ошибка при удалении задачи', 'danger');
        }
        $this->redirect('tasks', 'list');
    }
}