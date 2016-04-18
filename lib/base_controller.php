<?php

class BaseController {

    public static function get_user_logged_in() {


        if (isset($_SESSION['opettaja'])) {
            $opettaja_id = $_SESSION['opettaja'];

            $opettaja = Opettaja::find($opettaja_id);

            return $opettaja;
        }

        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['opettaja'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }

    public static function logout() {
        $_SESSION['opettaja'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }
    

}
