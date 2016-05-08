<?php

class Laboratoriokurssi extends BaseModel {

    public $id, $opettaja_id, $nimi, $kuvaus;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_kuvaus');
    }
//listaa kurssit
    public static function all() {
        $kysely = DB::connection()->prepare('SELECT * FROM Laboratoriokurssi');

        $kysely->execute();

        $rows = $kysely->fetchAll();
        $kurssit = array();

        foreach ($rows as $row) {
            $kurssit[] = new Laboratoriokurssi(array(
                'id' => $row['id'],
                'opettaja_id' => $row['opettaja_id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus']
            ));
        }
        return $kurssit;
    }
//löydä yksittäinen kurssi
    public static function find($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Laboratoriokurssi WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));
        $row = $kysely->fetch();

        if ($row) {
            $kurssi = new Laboratoriokurssi(array(
                'id' => $row['id'],
                'opettaja_id' => $row['opettaja_id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus']
            ));

            return $kurssi;
        }

        return null;
    }
//kurssin lisäys
    public function save() {
        $kysely = DB::connection()->prepare('INSERT INTO Laboratoriokurssi (opettaja_id ,nimi, kuvaus) VALUES (:opettaja_id ,:nimi, :kuvaus) RETURNING id');
        $kysely->execute(array('opettaja_id' => $this->opettaja_id, 'nimi' => $this->nimi, 'kuvaus' => $this->kuvaus));
        $row = $kysely->fetch();

//        Kint::trace();
//        Kint::dump($row);

        $this->id = $row['id'];
    }
//kurssin muokkaus
    public function update() {
        $kysely = DB::connection()->prepare('UPDATE Laboratoriokurssi SET nimi = :nimi, kuvaus = :kuvaus WHERE id = :id');
        $kysely->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'id' => $this->id));
        $row = $kysely->fetch();

//        $this->id = $row['id'];
    }
//listaa kurssin työaiheet
    public function tyoaiheet($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Labratyoaihe WHERE laboratoriokurssi_id = :id');
        $kysely->execute(array('id' => $id));
        $rows = $kysely->fetchAll();
        $tyoaiheet = array();

        foreach ($rows as $row) {
            $tyoaiheet[] = Tyoaihe::find($row['tyoaihe_id']);
        }
        return $tyoaiheet;
    }
//poista kurssi
    public function destroy() {
        $kysely = DB::connection()->prepare('DELETE FROM Laboratoriokurssi WHERE id = :id');
        $kysely->execute(array('id' => $this->id));
        $row = $kysely->fetch();
    }
//lisää työaihe kurssille
    public function tyoaihe_add($id, $tyoaihe_id) {
        $kysely = DB::connection()->prepare('INSERT INTO Labratyoaihe (laboratoriokurssi_id, tyoaihe_id) SELECT :id, :tyoaihe_id WHERE NOT EXISTS (SELECT * FROM Labratyoaihe WHERE laboratoriokurssi_id = :id AND tyoaihe_id = :tyoaihe_id)');
        $kysely->execute(array('id' => $id, 'tyoaihe_id' => $tyoaihe_id));
        $row = $kysely->fetch();
    }
//työaihen poisto kurssilta
    public function tyoaihe_destroy($id, $tyoaihe_id) {
        $kysely = DB::connection()->prepare('DELETE FROM Labratyoaihe WHERE laboratoriokurssi_id = :id AND tyoaihe_id = :tyoaihe_id');
        $kysely->execute(array('id' => $id, 'tyoaihe_id' => $tyoaihe_id));
    }
//validoinnit
    public function validate_nimi() {
        return parent::validate_string_length($this->nimi, 50);
    }

    public function validate_kuvaus() {
        return parent::validate_string_length($this->kuvaus, 2000);
    }

}
