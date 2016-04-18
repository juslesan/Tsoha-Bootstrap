<?php

class Suoritus_controller extends BaseController {

    public static function suoritus_list($tyoaihe_id) {

        $suoritukset = Suoritus::all($tyoaihe_id);

        $tyoaihe = Tyoaihe::find($tyoaihe_id);

        View::make('suunnitelmat/suoritukset.html', array('suoritukset' => $suoritukset, 'tyoaihe' => $tyoaihe));
    }
//uusi
    public static function store($tyoaihe_id) {
        parent::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'opettaja_id' => $_SESSION['opettaja'],
            'tyoaihe_id' => $tyoaihe_id,
            'arvosana' => $params['arvosana'],
            'suoritusaika' => $params['suoritusaika']
        );
        $suoritus = new Suoritus($attributes);

        $errors = $suoritus->errors();

        if (count($errors) == 0) {

            $suoritus->save();

            Redirect::to('/tyoaiheet/' . $tyoaihe_id . '/suoritukset', array('message' => 'Työaihelle on lisätty suoritus!'));
        } else {

            View::make('/suunnitelmat/newSuoritus.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
//uusi
    public static function create($id) {
        parent::check_logged_in();
        View::make('suunnitelmat/newSuoritus.html', array('tyoaihe' => $id, 'opettaja' => $_SESSION['opettaja']));
    }
//esittely
    public static function show($tyoaihe_id, $id) {
        parent::check_logged_in();
        $suoritus = Suoritus::find($tyoaihe_id, $id);
        View::make('suunnitelmat/suoritus.html', array('suoritus' => $suoritus));
    }
//muokkaus
    public static function edit($tyoaihe_id, $id) {
        parent::check_logged_in();
        $suoritus = Suoritus::find($tyoaihe_id, $id);
        View::make('suunnitelmat/suoritus_edit.html', array('suoritus' => $suoritus));
    }
//muokkaus
     public static function update($tyoaihe_id, $id) {
        parent::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'tyoaihe_id' => $tyoaihe_id,
            'opettaja_id' =>$_SESSION['opettaja'],
            'arvosana' => $params['arvosana'],
            'suoritusaika' => $params['suoritusaika']
        );
        $suoritus = new Suoritus($attributes);
        $errors = $suoritus->errors();

        if (count($errors) > 0) {
            View::make('suunnitelmat/suoritus_edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $suoritus->update();

            Redirect::to('/tyoaiheet/' . $tyoaihe_id . '/suoritukset/' . $id, array('message' => 'Suoritusmerkintää on muokattu onnistuneesti!'));
        }
    }
//poisto
    public static function destroy($tyoaihe_id, $id) {
        parent::check_logged_in();

        $suoritus = Suoritus::find($tyoaihe_id, $id);

        $suoritus->destroy();

        Redirect::to('/tyoaiheet/'. $tyoaihe_id . '/suoritukset', array('message' => 'Suoritus on poistettu onnistuneesti!'));
    }
}

