<?php

class Tyoaihe extends BaseModel {

    public $id, $nimi, $kuvaus, $maara, $tuntimaara, $keskeytykset, $keskiarvo;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_kuvaus');
    }
//listaa kaikki työaiheet
    public static function all($params) {
        $tyoaiheet = array();
        $query_string = 'SELECT * FROM Tyoaihe';

        if (isset($params['search'])) {
            $query_string .= ' WHERE nimi LIKE :like';
            $params['like'] = '%' . $params['search'] . '%';
            $kysely = DB::connection()->prepare($query_string);
            $kysely->execute(array('like' => '%' . $params['search'] . '%'));
            $rows = $kysely->fetchAll();
        } else {
            $kysely = DB::connection()->prepare($query_string);

            $kysely->execute();

            $rows = $kysely->fetchAll();
        }
//haetaan suoritustiedot työaiheelle
        foreach ($rows as $row) {
            $suoritus = DB::connection()->prepare('SELECT * FROM Suoritus WHERE tyoaihe_id = :tyoaihe_id');
            $suoritus->execute(array('tyoaihe_id' => $row['id']));

            $rivit = $suoritus->fetchAll();

            $maara = 0;
            $tuntimaara = 0;
            $keskeytykset = 0;
            $keskiarvo = 0;

            foreach ($rivit as $rivi) {
                $maara = $maara + 1;
                $tuntimaara = $tuntimaara + $rivi['suoritusaika'];
                if ($rivi['arvosana'] == 0) {
                    $keskeytykset = $keskeytykset + 1;
                } else {
                    $keskiarvo = $keskiarvo += $rivi['arvosana'];
                }
            }

            if ($maara == 0) {
                $tyoaiheet[] = new Tyoaihe(array(
                    'id' => $row['id'],
                    'nimi' => $row['nimi'],
                    'kuvaus' => $row['kuvaus'],
                    'maara' => 0,
                    'tuntimaara' => 0,
                    'keskeytykset' => 0,
                    'keskiarvo' => 0
                ));
            } else {
                $tyoaiheet[] = new Tyoaihe(array(
                    'id' => $row['id'],
                    'nimi' => $row['nimi'],
                    'kuvaus' => $row['kuvaus'],
                    'maara' => $maara,
                    'tuntimaara' => round($tuntimaara / $maara),
                    'keskeytykset' => $keskeytykset,
                    'keskiarvo' => round($keskiarvo / $maara,2)
                ));
            }
        }

        return $tyoaiheet;
    }
//löydä yksittäinen työaihe
    public static function find($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Tyoaihe WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));
        $row = $kysely->fetch();

//        haetaan suoritustiedot
        $suoritus = DB::connection()->prepare('SELECT * FROM Suoritus WHERE tyoaihe_id = :tyoaihe_id');
        $suoritus->execute(array('tyoaihe_id' => $row['id']));

        $rivit = $suoritus->fetchAll();

        $maara = 0;
        $tuntimaara = 0;
        $keskeytykset = 0;
        $keskiarvo = 0;

        foreach ($rivit as $rivi) {
            $maara = $maara + 1;
            $tuntimaara = $tuntimaara + $rivi['suoritusaika'];
            if ($rivi['arvosana'] == 0) {
                $keskeytykset = $keskeytykset + 1;
            } else {
                $keskiarvo = $keskiarvo += $rivi['arvosana'];
            }
        }

        if ($row) {

            if ($maara == 0) {
                $tyoaihe = new Tyoaihe(array(
                    'id' => $row['id'],
                    'nimi' => $row['nimi'],
                    'kuvaus' => $row['kuvaus'],
                    'maara' => 0,
                    'tuntimaara' => 0,
                    'keskeytykset' => 0,
                    'keskiarvo' => 0
                ));
            } else {
                $tyoaihe = new Tyoaihe(array(
                    'id' => $row['id'],
                    'nimi' => $row['nimi'],
                    'kuvaus' => $row['kuvaus'],
                    'maara' => $maara,
                    'tuntimaara' => $tuntimaara / $maara,
                    'keskeytykset' => $keskeytykset,
                    'keskiarvo' => $keskiarvo / $maara
                ));
            }

            return $tyoaihe;
        }

        return null;
    }
//lisää työaihe
    public function save() {
        $kysely = DB::connection()->prepare('INSERT INTO Tyoaihe (nimi, kuvaus) VALUES (:nimi, :kuvaus) RETURNING id');
        $kysely->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus));
        $row = $kysely->fetch();

//        Kint::trace();
//        Kint::dump($row);

        $this->id = $row['id'];
    }
//muokkaa työaihetta
    public function update() {
        $kysely = DB::connection()->prepare('UPDATE Tyoaihe SET nimi = :nimi, kuvaus = :kuvaus WHERE id = :id');
        $kysely->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'id' => $this->id));
        $row = $kysely->fetch();

//        $this->id = $row['id'];
    }
//poista työaihe
    public function destroy() {
        $kysely2 = DB::connection()->prepare('DELETE FROM Suoritus WHERE tyoaihe_id = :id');
        $kysely2->execute(array('id' => $this->id));

        $kysely3 = DB::connection()->prepare('DELETE FROM Labratyoaihe WHERE tyoaihe_id = :id');
        $kysely3->execute(array('id' => $this->id));

        $kysely = DB::connection()->prepare('DELETE FROM Tyoaihe WHERE id = :id');
        $kysely->execute(array('id' => $this->id));
        $row = $kysely->fetch();
    }
//validoinnit
    public function validate_nimi() {
        return parent::validate_string_length($this->nimi, 50);
    }

    public function validate_kuvaus() {
        return parent::validate_string_length($this->kuvaus, 3000);
    }

}
