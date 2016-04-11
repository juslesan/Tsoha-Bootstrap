<?php

class Tyoaihe extends BaseModel {

    public $id, $nimi, $kuvaus;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_kuvaus');
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

    public function update() {
        $kysely = DB::connection()->prepare('UPDATE Tyoaihe SET nimi = :nimi, kuvaus = :kuvaus WHERE id = :id');
        $kysely->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'id' => $this->id));
        $row = $kysely->fetch();

//        $this->id = $row['id'];
    }

    public function destroy() {
        $kysely = DB::connection()->prepare('DELETE FROM Tyoaihe WHERE id = :id');
        $kysely->execute(array('id' => $this->id));
        $row = $kysely->fetch();
        
        
    }

    public function validate_nimi() {
        return parent::validate_string_length($this->nimi, 50);
    }

    public function validate_kuvaus() {
        return parent::validate_string_length($this->kuvaus, 3000);
    }

}
