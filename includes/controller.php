<?php
namespace includes;

abstract class Controller {
    protected $title;

    function __construct() {
        $title = 'Nuvei';
    }

    abstract function index();
}
