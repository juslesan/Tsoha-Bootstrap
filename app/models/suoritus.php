<?php

class Suoritus extends BaseModel {

    public $id, $opettaja_id, $tyoaihe_id, $arvosana, $suoritusaika;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_arvosana', 'validate_suoritusaika');
    }

    public static function all($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Suoritus WHERE tyoaihe_id = :id');

        $kysely->execute(array('id' => $id));;

        $rows = $kysely->fetchAll();
        $suoritukset = array();


        foreach ($rows as $row) {

            $suoritukset[] = new Suoritus(array(
                'id' => $row['id'],
                'opettaja_id' => $row['opettaja_id'],
                'tyoaihe_id' => $row['tyoaihe_id'],
                'arvosana' => $row['arvosana'],
                'suoritusaika' => $row['suoritusaika']
            ));
        }

        return $suoritukset;
    }

    public static function find($tyoaihe_id, $id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Suoritus WHERE tyoaihe_id = :tyoaihe_id AND id = :id  LIMIT 1');
        $kysely->execute(array('tyoaihe_id' => $tyoaihe_id, 'id' => $id));
        $row = $kysely->fetch();

        if ($row) {
            $suoritus = new Suoritus(array(
                'id' => $row['id'],
                'opettaja_id' => $row['opettaja_id'],
                'tyoaihe_id' => $row['tyoaihe_id'],
                'arvosana' => $row['arvosana'],
                'suoritusaika' => $row['suoritusaika']
            ));

            return $suoritus;
        }

        return null;
    }
    public function save() {
        $kysely = DB::connection()->prepare('INSERT INTO Suoritus (opettaja_id, tyoaihe_id, arvosana, suoritusaika) VALUES (:opettaja_id, :tyoaihe_id, :arvosana, :suoritusaika) RETURNING id');
        $kysely->execute(array('opettaja_id' => $this->opettaja_id, 'tyoaihe_id' => $this->tyoaihe_id, 'arvosana' => $this->arvosana, 'suoritusaika' => $this->suoritusaika));
        $row = $kysely->fetch();

//        Kint::trace();
//        Kint::dump($row);

        $this->id = $row['id'];
    }

    public function update() {
        $kysely = DB::connection()->prepare('UPDATE Suoritus SET opettaja_id = :opettaja_id, tyoaihe_id = :tyoaihe_id, arvosana = :arvosana, suoritusaika = :suoritusaika WHERE id = :id');
        $kysely->execute(array('opettaja_id' => $this->opettaja_id, 'tyoaihe_id' => $this->tyoaihe_id, 'arvosana' => $this->arvosana, 'suoritusaika' => $this->suoritusaika, 'id' => $this->id));
        $row = $kysely->fetch();

//        $this->id = $row['id'];
    }

    public function destroy() {
        $kysely = DB::connection()->prepare('DELETE FROM Suoritus WHERE id = :id');
        $kysely->execute(array('id' => $this->id));
        $row = $kysely->fetch();
        
        
    }

    public function validate_arvosana() {
        return parent::validate_integer($this->arvosana, 0, 5);
    }

    public function validate_suoritusaika() {
        return parent::validate_integer($this->suoritusaika, 0, 3000);
    }

}
