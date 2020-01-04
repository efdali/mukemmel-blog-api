<?php
class App
{

    public $controller = "postController";
    public $method = "index";
    public $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        if(isset($url[0])) {
            $controllerUrl = $url[0] . "Controller";
            if (file_exists(CDIR . $controllerUrl . ".php")) {
                $this->controller = $controllerUrl;
                array_shift($url);
            }
        }
        require_once CDIR.$this->controller.".php";
        $this->controller=new $this->controller;

        if (isset($url[0])){
            if (method_exists($this->controller,$url[0])){
                $this->method=$url[0];
                array_shift($url);
            }
        }

        $this->params=$url ? array_values($url) : [];
        call_user_func_array([$this->controller,$this->method],$this->params);


    }

    public function parseUrl()
    {

        if (isset($_GET["url"])) {
            return explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));
        }

    }

}