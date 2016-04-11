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

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus']
        );
        $tyoaihe = new Tyoaihe($attributes);
        $errors = $tyoaihe->errors();

        if (count($errors) > 0) {
            View::make('suunnitelmat/tyoaihe_edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $tyoaihe->update();

            Redirect::to('/tyoaiheet/' . $tyoaihe->id, array('message' => 'Työaihetta on muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id) {

        $tyoaihe = Tyoaihe::find($id);

        $tyoaihe->destroy();

        Redirect::to('/tyoaiheet', array('message' => 'Tyoaihe on poistettu onnistuneesti!'));
    }

    public static function store() {
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

            View::make('/suunnitelmat/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
        View::make('suunnitelmat/new.html');
    }

}
