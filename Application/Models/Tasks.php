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
}