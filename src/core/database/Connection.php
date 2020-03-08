<?php

namespace EduCat\Core\Database;


class Connection
{
    /**
     * Build connection to the database
     * 
     * @param EduCat\Config $config Config with required credentials
     * @return \PDO $pdo PDO authenticated to interact with the database
     */
    public static function make($config)
    {
        try {
            return $pdo = new \PDO(
                $config['connection'] . ';dbname=' . $config['name'],
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
