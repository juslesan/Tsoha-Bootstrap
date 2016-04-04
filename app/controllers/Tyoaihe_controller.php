<?php

class Tyoaihe_controller extends BaseController {

    public static function index() {

        $tyoaiheet = Tyoaihe::all();

        View::make('suunnitelmat/tyoaihe_list.html', array('tyoaiheet' => $tyoaiheet));
    }

    public static function show($id) {

        $tyoaihe = Tyoaihe::find($id);

        View::make('suunnitelmat/tyoaihe_show.html', array('tyoaihe' => $tyoaihe));
    }

    public static function edit($id) {
        $tyoaihe = Tyoaihe::find($id);

        View::make('suunnitelmat/tyoaihe_edit.html', array('tyoaihe' => $tyoaihe));
    }

    public static function store() {
        $params = $_POST;

        $tyoaihe = new Tyoaihe(array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus']
        ));

//        Kint::dump($params);

        $tyoaihe->save();

        Redirect::to('/tyoaiheet/' . $tyoaihe->id, array('message' => 'Työaihe on lisätty kantaan!'));
    }

    public static function create() {
        View::make('suunnitelmat/new.html');
    }

}
