<?php

namespace Application\Models;

use Framework\Model;

class Users extends Model
{
    public function login($username, $passwordHash)
    {
        $statementString = 'SELECT `id` FROM `users` WHERE `username`=:user AND `password`=:pass';
        $stmt = $this->getConnection()->prepare($statementString);
        $stmt->bindParam(':user', $username, \PDO::PARAM_STR, 32);
        $stmt->bindParam(':pass', $passwordHash, \PDO::PARAM_STR, 32);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}