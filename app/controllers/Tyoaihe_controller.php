<?php

class Tyoaihe_controller extends BaseController {

//listaus
    public static function index() {

        $params = $_GET;
        if (isset($params['search'])) {
            $tyoaiheet = Tyoaihe::all($params);
            View::make('tyoaihe/tyoaihe_list.html', array('tyoaiheet' => $tyoaiheet));
        } else {

            $tyoaiheet = Tyoaihe::all($params);
            View::make('tyoaihe/tyoaihe_list.html', array('tyoaiheet' => $tyoaiheet));
        }
    }

//esittely
    public static function show($id) {

        $tyoaihe = Tyoaihe::find($id);

        View::make('tyoaihe/tyoaihe_show.html', array('tyoaihe' => $tyoaihe));
    }

//muokkaus
    public static function edit($id) {
        parent::check_logged_in();
        $tyoaihe = Tyoaihe::find($id);

        View::make('tyoaihe/tyoaihe_edit.html', array('tyoaihe' => $tyoaihe));
    }

//muokkaus
    public static function update($id) {
        parent::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus']
        );
        $tyoaihe = new Tyoaihe($attributes);
        $errors = $tyoaihe->errors();

        if (count($errors) > 0) {
            View::make('tyoaihe/tyoaihe_edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $tyoaihe->update();

            Redirect::to('/tyoaiheet/' . $tyoaihe->id, array('message' => 'Työaihetta on muokattu onnistuneesti!'));
        }
    }

//poisto
    public static function destroy($id) {
        parent::check_logged_in();

        $tyoaihe = Tyoaihe::find($id);

        $tyoaihe->destroy();

        Redirect::to('/tyoaiheet', array('message' => 'Tyoaihe on poistettu onnistuneesti!'));
    }

//lisäys
    public static function store() {
        parent::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus']
        );
        $tyoaihe = new Tyoaihe($attributes);

        $errors = $tyoaihe->errors();

        if (count($errors) == 0) {

            $tyoaihe->save();

            Redirect::to('/tyoaiheet/' . $tyoaihe->id, array('message' => 'Työaihe on lisätty kantaan!'));
        } else {

            View::make('/tyoaihe/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

//lisäys
    public static function create() {
        parent::check_logged_in();
        View::make('tyoaihe/new.html');
    }

}
