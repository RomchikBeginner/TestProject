<?php

namespace TestProject\Models\ClientsProfiles;
use TestProject\Models\ActiveRecordEntity;
use TestProject\MOdels\Clients\Client;

class ClientProfile extends ActiveRecordEntity
{
    protected $clientId;
    protected $position;
    protected $workPhoneNumber;
    protected $homePhoneNumber;
    protected $additionalPhoneNumber;
    protected $companyId;

    protected static function getTableName(): string
    {
        return 'clients_profiles';
    }

    protected static function getIdText(): string
    {
        return 'client_id';
    }

    protected function setClient(int $client): void
    {
        $this->clientId = $client;
    }

    protected function setPosition(string $position): void
    {
        $this->position = $position;
    }

    protected function setWorkPhoneNumber(string $workPhoneNumber): void
    {
        $this->workPhoneNumber = $workPhoneNumber;
    }

    protected function setHomePhoneNumber(string $homePhoneNumber): void
    {
        $this->homePhoneNumber = $homePhoneNumber;
    }

    protected function setAdditionalPhoneNumber(string $additionalPhoneNumber): void
    {
        $this->additionalPhoneNumber = $additionalPhoneNumber;
    }

    protected function setCompany(?int $id): void
    {
        $this->companyId = $id;
    }

    public function getClientId(): int
    {
        return (int) $this->clientId;
    }

    public function getCompanyId(): int|null
    {
        return (int) $this->companyId ?? null;
    }

    public function getPosition(): string
    {
        return (string) $this->position;
    }

    public function getWorkPhoneNumber(): string
    {
        return (string) $this->workPhoneNumber;
    }

    public function getHomePhoneNumber(): string
    {
        return (string) $this->homePhoneNumber;
    }

    public function getAdditionalPhoneNumber(): string
    {
        return (string) $this->additionalPhoneNumber;
    }
}

?>