<?php

class Tyoaihe extends BaseModel {

    public $id, $nimi, $kuvaus;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $kysely = DB::connection()->prepare('SELECT * FROM Tyoaihe');

        $kysely->execute();

        $rows = $kysely->fetchAll();
        $tyoaiheet = array();


        foreach ($rows as $row) {

            $tyoaiheet[] = new Tyoaihe(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
            ));
        }

        return $tyoaiheet;
    }

    public static function find($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Tyoaihe WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));
        $row = $kysely->fetch();

        if ($row) {
            $tyoaihe = new Tyoaihe(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
            ));

            return $tyoaihe;
        }

        return null;
    }

    public function save() {
        $kysely = DB::connection()->prepare('INSERT INTO Tyoaihe (nimi, kuvaus) VALUES (:nimi, :kuvaus) RETURNING id');
        $kysely->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus));
        $row = $kysely->fetch();

//        Kint::trace();
//        Kint::dump($row);

        $this->id = $row['id'];
    }

}
