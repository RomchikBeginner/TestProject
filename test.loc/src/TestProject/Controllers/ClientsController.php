<?php

namespace TestProject\Controllers;

use InvalidArgumentException;
use TestProject\Exceptions\NotFoundException;
use TestProject\Models\Clients\Client;
use TestProject\Models\ClientsProfiles\ClientProfile;
use TestProject\Models\Companies\Company;
use TestProject\View\View;


class ClientsController
{
    /** @var View */
    private $view;

    public function __construct() 
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function view(int $clientId): void
    {
        $client = Client::getById($clientId);

        if ($client === null) {
            throw new NotFoundException();
        }
        $clientProfile = ClientProfile::getById($client->getId(),'client_id');  

        $this->view->renderHTML('clients/view.php', [
            'client'=>$client,
            'clientProfile'=>$clientProfile
        ]);
    }

    public function edit(int $clientId): void
    {
        $client = Client::getById($clientId);

        if ($client === null) {
            throw new NotFoundException();
        }

        
        if (!empty($_POST)) {
            try {
                $client->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHTML('clients/edit.php', 
                ['error' => $e->getMessage(), 
                'client' => $client]
                );
                return;
            }
        
            header('Location: /clients/' . $client->getId(), true, 302);
            exit();
        }
        $clientProfile = ClientProfile::getById($client->getId(),'client_id');
        $company = Company::getById($clientProfile->getCompanyId());
        
            $this->view->renderHTML('clients/edit.php', ['client' => $client,
            'company' => $company,
            'clientProfile' => $clientProfile]);

    }

    public function delete(int $clientId): void
    {
        Client::delete($clientId);
        header('Location: /', true, 302);
        exit();
    }

    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $client = Client::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHTML('clients/signUp.php', ['error' => $e->getMessage()]);
                return;
            }

            if ($client instanceof Client) {
                $this->view->renderHTML('clients/signUpSuccessfull.php');
                return;
            }
        }

        $this->view->renderHTML('clients/signUp.php');
    }
}

?>