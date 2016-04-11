<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('suunnitelmat/etusivu.html');
    }

    public static function sandbox() {
        $aihe = new Tyoaihe(array(
            'nimi' => 'd',
            'kuvaus' => 'Boom, boom!'
        ));
        $errors = $aihe->errors();

        Kint::dump($errors);
    }

    public static function edit() {
        View::make('suunnitelmat/tyoaihe_edit.html');
    }

    public static function tyoaihe() {
        View::make('suunnitelmat/tyoaihe_show.html');
    }

    public static function tyoaiheet() {
        View::make('suunnitelmat/tyoaihe_list.html');
    }

}
