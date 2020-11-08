<?php

namespace Application\Controllers;

use Framework\Tools;
use Framework\Controller;
use Framework\View;
use Framework\Session;
use Application\Models\Users as UserModel;

class Users extends Controller
{
    public $title = 'Пользователи';

    function actionIndex($arParameters)
    {
        $this->redirect('tasks');
    }
    function actionLogin($arParameters)
    {
        $this->title = 'Авторизация';
        if (Session::get('user')) {
            $this->alert('Поворная авторизация не требуется', 'danger');
            $this->redirect('tasks');
        }

        if (array_key_exists('username', $arParameters)) {
            if (strlen($arParameters['username']) > 0) {

                // Удаляем все запрещённые символы и обрезаем строку если длиннее 32 символов
                $username = preg_replace('/\W/', '', $arParameters['username']);
                $username = substr($username, 0, 32);

                // Паполь превращаем в хеш, потому спецсимволов там не боимся
                $password = array_key_exists('password', $arParameters) ? $arParameters['password'] : '';
                $password = md5($password);

                $userModel = new UserModel();
                $userId = $userModel->login($username, $password);

                if ($userId > 0) {
                    Session::set('user', $username);
                    $this->alert('Успешная авторизация', 'success');
                    Tools::log('Авторизация: ' . $username);
                    $this->redirect('tasks');
                } else {
                    $this->alert('Ошибка авторизации', 'danger');
                    Tools::log('Ошибка авторизации: ' . $username);
                }
            } 
        }
        return View::render('users/login.tmpl.php', [
            'username' => array_key_exists('username', $arParameters) ? $arParameters['username'] : '',
            'password' => array_key_exists('password', $arParameters) ? $arParameters['password'] : '',
        ]);
    }
    
    function actionLogout()
    {
        if (!Session::get('user')) {
            $this->alert('Ошибка доступа', 'danger');
            $this->redirect('tasks');
        }
        $username = Session::get('user');
        $this->alert('Успешный выход', 'success');
        Tools::log('Выход: ' . $username);
        Session::deleteVariable('user');
        $this->redirect('tasks');
    }
}