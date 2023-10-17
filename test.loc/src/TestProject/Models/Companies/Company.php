<?php

namespace TestProject\Models\Companies;

use TestProject\Models\ActiveRecordEntity;

class Company extends ActiveRecordEntity
{
    protected $id;
    protected $name;
    protected static function getTableName(): string
    {
        return 'companies';
    }

    protected static function getIdText(): string
    {
        return 'id';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    protected function setNameCompany(string $name): void
    {
        $this->name = $name;
    }
}

?>