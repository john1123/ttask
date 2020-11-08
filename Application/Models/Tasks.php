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
    
    public function getTasksPage($number)
    {
        $offset = $number > 0 ? $number * PAGE_SIZE - PAGE_SIZE : 0;
        $pageSize = PAGE_SIZE;
        $statementString = 'SELECT `id`, `username`, `email`, `task`, `done` FROM `tasks` ORDER BY `id` LIMIT :offset, :rowcount';
        $stmt = $this->getConnection()->prepare($statementString);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':rowcount', $pageSize, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}