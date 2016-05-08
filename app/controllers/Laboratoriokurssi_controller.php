<?php

class Laboratoriokurssi_controller extends BaseController {

    public static function all() {

        $kurssit = Laboratoriokurssi::all();

        View::make('laboratoriokurssi/laboratoriokurssi_list.html', array('kurssit' => $kurssit));
    }

    //esittely
    public static function show($id) {

        $kurssi = Laboratoriokurssi::find($id);

        View::make('laboratoriokurssi/laboratoriokurssi_show.html', array('kurssi' => $kurssi));
    }

//muokkaus
    public static function edit($id) {
        parent::check_logged_in();
        $kurssi = Laboratoriokurssi::find($id);

        View::make('laboratoriokurssi/laboratoriokurssi_edit.html', array('kurssi' => $kurssi));
    }

//muokkaus
    public static function update($id) {
        parent::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
//            'opettaja_id' => $params['opettaja_id'],
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus']
        );
        $kurssi = new Laboratoriokurssi($attributes);
        $errors = $kurssi->errors();

        if (count($errors) > 0) {
            View::make('laboratoriokurssi/laboratoriokurssi_edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $kurssi->update();

            Redirect::to('/kurssit/' . $kurssi->id, array('message' => 'Laboratoriokurssia on muokattu onnistuneesti!'));
        }
    }

//poisto
    public static function destroy($id) {
        parent::check_logged_in();

        $kurssi = Laboratoriokurssi::find($id);

        $kurssi->destroy();

        Redirect::to('/kurssit', array('message' => 'Kurssi on poistettu onnistuneesti!'));
    }

    //lisäys
    public static function store() {
        parent::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'opettaja_id' => $_SESSION['opettaja'],
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus']
        );
        $kurssi = new Laboratoriokurssi($attributes);

        $errors = $kurssi->errors();

        if (count($errors) == 0) {

            $kurssi->save();

            Redirect::to('/kurssit/' . $kurssi->id, array('message' => 'Laboratoriokurssi on lisätty kantaan!'));
        } else {

            View::make('/laboratoriokurssi/laboratoriokurssi_new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

//lisäys
    public static function create() {
        parent::check_logged_in();
        View::make('laboratoriokurssi/laboratoriokurssi_new.html');
    }

//työaihe listaus
    public static function tyoaiheet($id) {
        $tyoaiheet = Laboratoriokurssi::tyoaiheet($id);

        View::make('laboratoriokurssi/laboratoriokurssi_tyoaiheet.html', array('kurssi' => $id, 'tyoaiheet' => $tyoaiheet));
    }

//työaihe lisäys
    public static function tyoaihe_add($id) {
        parent::check_logged_in();
        $params = $_GET;
        $tyoaiheet = Tyoaihe::all($params);
        View::make('laboratoriokurssi/laboratoriokurssi_addtyoaihe.html', array('tyoaiheet' => $tyoaiheet, 'kurssi' => $id));
    }

    public static function tyoaihe_store($id) {
        parent::check_logged_in();
        $tyoaiheet = $_POST['tyoaiheet'];

        $attributes = array();
        foreach ($tyoaiheet as $tyoaihe) {
            Laboratoriokurssi::tyoaihe_add($id, $tyoaihe);
        }

        Redirect::to('/kurssit/' . $id . '/tyoaiheet', array('message' => 'Laboratoriokurssille lisätty työaiheita!'));
    }

    // työaiheen poisto
    public static function tyoaihe_destroy($id, $tyoaihe_id) {
        parent::check_logged_in();
        
        Laboratoriokurssi::tyoaihe_destroy($id, $tyoaihe_id);

        Redirect::to('/kurssit/'. $id . '/tyoaiheet', array('message' => 'Kurssi on poistettu onnistuneesti!'));
    }

}
