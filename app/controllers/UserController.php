<?php

class UserController extends BaseController{
  public static function login(){
      View::make('suunnitelmat/kirjautuminen.html');
  }
  public static function handle_login(){
    $params = $_POST;

    $opettaja = Opettaja::authenticate($params['nimi'], $params['salasana']);

    if(!$opettaja){
      View::make('suunnitelmat/kirjautuminen.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'nimi' => $params['nimi']));
    }else{
      $_SESSION['opettaja'] = $opettaja->id;

      Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $opettaja->nimi . '!'));
    }
  }
}


