<?php

namespace Application\Models;

use Framework\Model;

class Tasks extends Model
{
    public function getTasksCount()
    {
        $stmt = $this->getConnection()->query( 'SELECT count(`id`) FROM `tasks`' );
        return $stmt->fetchColumn();
    }
    
    public function getTasksPage($number, $sortField='id', $sortOrder='asc')
    {
        $sortField = in_array($sortField, ['id', 'username', 'email', 'task', 'done']) ? $sortField : 'id';
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';
        $offset = $number > 0 ? $number * PAGE_SIZE - PAGE_SIZE : 0;
        $pageSize = PAGE_SIZE;
        $statementString = 'SELECT `id`, `username`, `email`, `task`, `done` FROM `tasks` ORDER BY ' . $sortField . ' ' . $sortOrder . ' LIMIT :offset, :rowcount';
        $stmt = $this->getConnection()->prepare($statementString);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':rowcount', $pageSize, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function get($taskId)
    {
        $stmt = $this->getConnection()->prepare( 'SELECT `id`, `username`, `email`, `task`, `done` FROM `tasks` WHERE `id`=?' );
        $stmt->bindParam(1, $taskId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function delete($taskId)
    {
        $stmt = $this->getConnection()->prepare( 'DELETE FROM `tasks` WHERE `id`=?' );
        $stmt->bindParam(1, $taskId, \PDO::PARAM_INT);
        $stmt->execute();
    }
    public function save($arTask)
    {
        $taskId = array_key_exists('id', $arTask) ? $arTask['id'] : 0;

        if (!array_key_exists('username', $arTask)) {
            throw new Exception('Unable to save a task without username');
        }
        $username = $arTask['username'];

        if (!array_key_exists('email', $arTask)) {
            throw new Exception('Unable to save a task without email');
        }
        $email = $arTask['email'];

        if (!array_key_exists('task', $arTask)) {
            throw new Exception('Unable to save a task without task`s text');
        }
        $task = $arTask['task'];
        
        if ($taskId > 0) {
            $stmt = $this->getConnection()->prepare( 'UPDATE `tasks` SET `username`=?, `email`=?, `task`=?, `done`=? WHERE `id`=?' );
            $stmt->bindParam(1, $username, \PDO::PARAM_STR, 32);
            $stmt->bindParam(2, $email, \PDO::PARAM_STR, 255);
            $stmt->bindParam(3, $task, \PDO::PARAM_STR, 255);
            if (array_key_exists('done', $arTask) && strlen($arTask['done'])) {
                $d = date('Y-m-d H:i:s');
                $stmt->bindParam(4, $d, \PDO::PARAM_STR, 19);
            } else {
                $n = null;
                $stmt->bindParam(4, $n, \PDO::PARAM_NULL);
            }
            $stmt->bindParam(5, $taskId, \PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $this->getConnection()->prepare( 'INSERT INTO `tasks` (`username`, `email`, `task`, `done`) VALUES (?, ?, ?, ?)' );
            $stmt->bindParam(1, $username, \PDO::PARAM_STR, 32);
            $stmt->bindParam(2, $email, \PDO::PARAM_STR, 255);
            $stmt->bindParam(3, $task, \PDO::PARAM_STR, 255);
            if (array_key_exists('done', $arTask) && strlen($arTask['done'])) {
                $d = date('Y-m-d H:i:s');
                $stmt->bindParam(4, $d, \PDO::PARAM_STR, 19);
            } else {
                $n = null;
                $stmt->bindParam(4, $n, \PDO::PARAM_NULL);
            }
            $stmt->execute();
        }
        
    }
}