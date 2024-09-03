<?php

class Router{

    private $server_uri = [];
    private $server_method;
    private $callback;
    private $matched = false;
    private $params = [];
    private $trim = '/\^$/';

    function __construct(){
        $uri = trim($_SERVER['REQUEST_URI'], $this->trim);
        $this->server_method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->server_uri = explode('/', $uri);
    }

    public function get($uri, $callback){
        $this->match('get', $uri, $callback);
    }

    public function post($uri, $callback){
        $this->match('post', $uri, $callback);
    }

    public function put($uri, $callback){
        $this->match('put', $uri, $callback);
    }

    public function patch($uri, $callback){
        $this->match('patch', $uri, $callback);
    }

    public function delete($uri, $callback){
        $this->match('delete', $uri, $callback);
    }

    public function add($method, $uri, $callback){
        $this->match(strtolower($method), $uri, $callback);
    }

    private function match($method, $uri, $callback){
        if ($this->matched) {
            return;
        }

        $uri = trim($uri, $this->trim);
        $current_uri = explode('/', $uri);
        $uri_length = count($current_uri);

        if ($method != $this->server_method) {
            return;
        }

        if ($uri_length != count($this->server_uri)) {
            return;
        }

        $matched = true;

        for ($i = 0; $i < $uri_length; $i++) {
            if ($current_uri[$i] == $this->server_uri[$i]) {
                continue;
            }
            if (isset($current_uri[$i][0]) && $current_uri[$i][0] == ':') {
                $this->params[substr($current_uri[$i], 1)] = $this->server_uri[$i];
                continue;
            }
            $matched = false;
            break;
        }

        if ($matched) {
            $this->callback = $callback;
            $this->matched = true;
        }
    }

    public function listen() {
        if (!$this->matched) {
            $this->defaultRoute();
            return;
        }

        call_user_func($this->callback, $this->params);
    }

    private function defaultRoute() {
        header("HTTP/1.1 404 Not Found");
        echo '404 - Not Found';
    }
}

// Example usage

