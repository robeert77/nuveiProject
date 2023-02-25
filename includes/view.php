<?php
namespace includes;

class View {
    protected $data;

    public function __construct(array $data = array()) {
        $this->data = $data;
    }

    // set data for the view
    public function setData(array $data) {
        $this->data = $data;
    }

    // render the view we recieve as a parameter
    public function renderView(string $file = '404') {
        // extract data in variables for the view
        extract($this->data);

        // include the view file
        include 'views/layouts/' . $file . '.php';
    }
}
