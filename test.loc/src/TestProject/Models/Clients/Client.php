<?php

namespace TestProject\Models\Clients;

use InvalidArgumentException;
use TestProject\Models\ActiveRecordEntity;
use TestProject\Models\ClientsProfiles\ClientProfile;
use TestProject\Models\Companies\Company;

class Client extends ActiveRecordEntity
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /** @var string */
    protected $email;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    protected static function getTableName(): string
    {
        return 'clients';
    }

    protected static function getIdText(): string
    {
        return 'id';
    }

    public function updateFromArray(array $clientData) 
    {
        static::checkField($clientData);

        $this->firstName = $clientData['clientFirstName'];
        $this->lastName = $clientData['clientLastName'];


        if ($this->email !== $clientData['clientEmail']) {
            if (static::findOneByColumn('email', $clientData['clientEmail']) !== null) {
                return throw new InvalidArgumentException('Пользователь с таким email уже существует');
            }
        }
        $this->email = $clientData['clientEmail'];
        $this->save($this->id);

        $companyId = null;

        if (!empty($clientData['companyName'])) {
            $res = Company::findOneByColumn('name', $clientData['companyName']);
            if ($res !== null) {
                $companyId = $res->getId();
            } else {
                $company = new Company();
                $company->setNameCompany($clientData['companyName']);
                $companyId = $company->save();
            }
        }
        
        $clientProfile = new ClientProfile();
        $clientProfile->setClient($this->id);
        $clientProfile->setCompany($companyId);
        $clientProfile->setPosition($clientData['clientPosition']);
        $clientProfile->setWorkPhoneNumber($clientData['phoneWork']);
        $clientProfile->setHomePhoneNumber($clientData['phoneHome']);
        $clientProfile->setAdditionalPhoneNumber($clientData['phoneAdditional']);
        $clientProfile->save($clientProfile->getClientId());

        return $this;
    }


    private static function checkField(array $clientData) 
    {
        if (empty($clientData['clientFirstName'])) {
            return throw new InvalidArgumentException('Не передан First Name');
        }

        if (!preg_match('/^[a-zA-Z]+$/', $clientData['clientFirstName'])) {
            return throw new InvalidArgumentException('First Name может состоять только из символов латинского алфавита');
        }

        if (empty($clientData['clientLastName'])) {
            return throw new InvalidArgumentException('Не передан Last Name');
        }

        if (!preg_match('/^[a-zA-Z]+$/', $clientData['clientLastName'])) {
            return throw new InvalidArgumentException('Last Name может состоять только из символов латинского алфавита');
        }

        if (empty($clientData['clientEmail'])) {
            return throw new InvalidArgumentException('Не передан Email');
        }

        if (!filter_var($clientData['clientEmail'], FILTER_VALIDATE_EMAIL)) {
            return throw new InvalidArgumentException('Email некорректен');
        }
    }

    private static function isValidPhoneNumber($phone)
    {
        $phone = preg_replace('/\D/', '', $phone);
  
        if (substr($phone, 0, 1) !== '7') {
            return throw new InvalidArgumentException('Номер должен начинаться на 7');
        }
  
        if (strlen($phone) !== 11) {
            return throw new InvalidArgumentException('Длина номера не равна 11');
        }
    }

    public static function signUp(array $clientData): InvalidArgumentException|Client
    {

        static::checkField($clientData);
        if (static::findOneByColumn('email', $clientData['clientEmail']) !== null) {
            return throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }

        if (!empty($clientData['phoneWork'])) {
            static::isValidPhoneNumber($clientData['phoneWork']);
            if (ClientProfile::findOneByColumn('work_phone_number', $clientData['phoneWork']) !== null) {
                return throw new InvalidArgumentException('Данный номер уже зарегистрирован');
            }
        }

        if (!empty($clientData['phoneHome'])) {
            static::isValidPhoneNumber($clientData['phoneHome']);
            if (ClientProfile::findOneByColumn('home_phone_number', $clientData['phoneHome']) !== null) {
                return throw new InvalidArgumentException('Данный номер уже зарегистрирован');
            }
        }

        if (!empty($clientData['phoneAdditional'])) {
            static::isValidPhoneNumber($clientData['phoneAdditional']);
            if (ClientProfile::findOneByColumn('additional_phone_number', $clientData['phoneAdditional']) !== null) {
                return throw new InvalidArgumentException('Данный номер уже зарегистрирован');
            }
        }

        $client = new Client();
        $client->firstName = $clientData['clientFirstName'];
        $client->lastName = $clientData['clientLastName'];
        $client->email = $clientData['clientEmail'];
        $clientId = $client->save();

        $clientProfile = new ClientProfile();
        $clientProfile->setClient($clientId);
        
        $companyId = null;

        if (!empty($clientData['companyName'])) {
            $res = Company::findOneByColumn('name', $clientData['companyName']);
            if ($res !== null) {
                $companyId = $res->getId();
            } else {
                $company = new Company();
                $company->setNameCompany($clientData['companyName']);
                $companyId = $company->save();
            }
        }

        
        $clientProfile->setCompany($companyId);
        $clientProfile->setPosition($clientData['clientPosition'] ?? null);
        $clientProfile->setWorkPhoneNumber($clientData['phoneWork'] ?? null);
        $clientProfile->setHomePhoneNumber($clientData['phoneHome'] ?? null);
        $clientProfile->setAdditionalPhoneNumber($clientData['phoneAdditional'] ?? null);
        $clientProfile->save();
        return $client;
    }
}

?>