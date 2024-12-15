<?php
// File: core/Controller.php

class Controller {
    // Memuat model
    public function model($model) {
        require_once "../app/models/$model.php";
        return new $model();
    }

    // Memuat view
    public function view($view, $data = []) {
        require_once "../app/views/$view.php";
    }
}
?>
