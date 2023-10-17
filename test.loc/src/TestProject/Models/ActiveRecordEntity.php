<?php

namespace TestProject\Models;

use TestProject\Services\Db;

abstract class ActiveRecordEntity
{
    /**
     * @return static[]
     */
    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    /**
     * @param int $id
     * @param string $nameColumn
     * @return static[]|null
     */
    public static function getById(int $id, string $nameColumn = 'id'): ?static
    {
        $db = Db::getInstance();
        $entities = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE '.$nameColumn.' = :id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }

    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    public function save(int $id = null)
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($id !== null) {
            return $this->update($mappedProperties,$id);
        } else {
            return $this->insert($mappedProperties);
        }
    }

    public function update(array $mappedProperties, int $id): void
    {
        $columns2Params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' .  $index;
            $columns2Params[] = $column . ' = ' . $param;
            $params2values[$param] = $value;
            $index++;
        }

        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2Params) . ' WHERE ' . static::getIdText() . ' = ' . $id . ';';
        
        
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    public function insert(array $mappedProperties, int $id = null): int|null
    {
        $filteredProperties = array_filter($mappedProperties);
        
        $columns = [];
        $paramsNames = [];
        $params2Values = [];
        foreach ($filteredProperties as $columnName => $value) {
            $columns[] = '`' . $columnName . '`';
            $paramsName = ':' . $columnName;
            $paramsNames[] = $paramsName;
            $params2Values[$paramsName] = $value;
        }

        
        $columnsViaSemicolon = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $paramsNames);

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';
        
        $db = Db::getInstance();
        $db->query($sql, $params2Values, static::class);
        $index  = $db->getLastInsertId();
        if ($id === null) {
            return $index;
        }   else {
            return null;
        }
    }

    public static function delete(int $clientId): ?array
    {
        $db = Db::getInstance();
        return $db->query(
            'DELETE FROM `' . static::getTableName() . '` WHERE id = :id',
            [':id' => $clientId]
        );
    }

    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }

        return $mappedProperties;
    }

    public static function findOneByColumn(string $columnName, $value): ?static
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `' . $columnName . '` = :value LIMIT 1;',
            [':value' => $value],
            static::class
        );
        return $result ? $result[0] : null;
    }
    
    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    protected function setNameCompany(string $name): void
    {
        throw new \RuntimeException('Not implemented');
    }

    protected function setClient(int $client): void
    {
        throw new \RuntimeException('Not implemented');
    }
    protected function setPosition(string $position): void
    {
        throw new \RuntimeException('Not implemented');
    }

    protected function setWorkPhoneNumber(string $workPhoneNumber): void
    {
        throw new \RuntimeException('Not implemented');
    }

    protected function setHomePhoneNumber(string $homePhoneNumber): void
    {
        throw new \RuntimeException('Not implemented');
    }

    protected function setAdditionalPhoneNumber(string $additionalPhoneNumber): void
    {
        throw new \RuntimeException('Not implemented');
    }

    protected function setCompany(int $id): void
    {
        throw new \RuntimeException('Not implemented');
    }

    public static function getPagesCount(int $itemsPerPage): int
    {
        $db = Db::getInstance();
        $result = $db->query('SELECT COUNT(*) AS cnt FROM ' . static::getTableName().';');
        return ceil($result[0]->cnt / $itemsPerPage);
    }

    public static function getPage(int $pageNum, int $itemsPerPage): array
    {
        $db = Db::getInstance();
        return $db->query(
            sprintf(
            'SELECT * FROM `%s` ORDER BY id DESC LIMIT %d OFFSET %d;',
            static::getTableName(),
            $itemsPerPage,
            ($pageNum-1) * $itemsPerPage
        ),[],static::class);
    }

    abstract protected static function getTableName(): string;
    abstract protected static function getIdText(): string;
}

?>