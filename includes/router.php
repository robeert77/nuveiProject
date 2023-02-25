<?php
namespace includes;

class Router {
    private $uri;

    public function __construct() {
        $this->uri = $this->processURI(explode('/', $_SERVER["REQUEST_URI"] ?? '/'));
    }

    public function renderContent() : void {
        if (class_exists($this->uri['controller'])) {
            $controller = $this->uri['controller'];
            $method = $this->uri['method'];
            $args = $this->uri['args'];

            $args ? (new $controller)->{$method}(...$args) :
                    (new $controller)->{$method}();
        }
        else { // something invalid
            $view = new View();
            $view->renderView();
        }
    }

    private function processURI($uri) : array {
        array_splice($uri, 0, 2); // for locahost configuration

        $controller = $uri[0] ?? '';
        $method = $uri[1] ?? '';
        $countParts = count($uri);
        $args = array();
        for ($i = 2; $i < $countParts; $i++) {
            $args[] = $uri[$i] ?? '';
        }

        // use default controller and method for empty uri
        $controller = !empty($controller) ? '\\controllers\\' . $controller . 'Controller' :
                                            '\\controllers\\authenticationController';
        $method = !empty($method) ? $method :
                                    'index';
        $args = !empty($args) ? $args :
                                array();

        return array(
            'controller' => $controller,
            'method' => $method,
            'args' => $args
        );
    }
}
