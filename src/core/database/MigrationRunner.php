<?php

namespace EduCat\Core\Database;

class MigrationRunner
{

    /**
     * @var \PDO $db 
     */
    protected $db;

    /**
     * Creates MigrationRunner
     * 
     * @param \PDO $db PDO to interact with the database
     */
    public function __construct($db)
    {
        $this->db = $db;
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Run query against database
     * 
     * @param string $query SQL query to be run
     */
    public function run($query)
    {
        try {
            $this->db->exec($query);
        } catch (\PDOException $e) {
            echo "Error running migrations:\n" . $e->getMessage() . "\n";
        }
    }
}
