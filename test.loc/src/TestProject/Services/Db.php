<?php

namespace TestProject\Services;
use TestProject\Exceptions\DbException;

class Db
{
    /** @var \PDO */
    private $pdo;

    private static $instance;

    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../../settings.php')['db'];
        try {   
            $this->pdo = new \PDO(
                'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
                $dbOptions['user'],
                $dbOptions['password'] 
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new DbException('Ошибка при подключении к БД: ' . $e->getMessage());
        }
    }

    public function query(string $sql, $params = [], $className = 'stdClass'): ?array 
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if ($result === null) {
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}

?>