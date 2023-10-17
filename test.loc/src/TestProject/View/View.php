<?php

namespace TestProject\View;

class View
{
    private $templatesPath;

    public function __construct($templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }

    public function renderHTML(string $templateName, array $vars = [], $code = 200)
    {
        http_response_code($code);
        extract($vars);

        include $this->templatesPath . '/' . $templateName;
    }
}

?>