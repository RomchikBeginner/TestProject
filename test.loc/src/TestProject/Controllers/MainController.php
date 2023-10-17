<?php

namespace TestProject\Controllers;

use TestProject\MOdels\Clients\Client;
use TestProject\Models\ClientsProfiles\ClientProfile;
use TestProject\View\View;

class MainController
{
    /** @var View */
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function main()
    {
        $this->page(1);
    }

    public function page(int $pageNum)
    {
        $this->view->renderHTML('main/main.php',[
            'profiles' => Client::getPage($pageNum,10),
            'pagesCount' => Client::getPagesCount(10),
            'currentPageNum' =>$pageNum
        ]);
    }
}

?>