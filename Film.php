<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 03/04/2015
 * Time: 11:51
 */

namespace Film;
require_once('\Dao.php');



class Film extends \Dao{

    private $instance = null;
    private $id = null;
    private $titre = NULL;
    private $releaseDate = NULL;
/*
    public function __construct($mode) {
        if($mode == 'set'){
            $this->instance = \Dao::getInstance();
            $query = 'INSERT INTO movieepsi.films (id, titre, auteur, dateSortie) VALUES (NULL, \'titleNotYetDefined\', \'autorNotYetDefined\', 0000);';
            $this->instance->exec($query);
            $this->id = $this->instance->lastInsertId();
            //echo($this->instance->lastInsertId());
        }elseif($mode == 'get'){

        }

    }
*/

    public function __construct()
    {
        $this->instance = \Dao::getInstance();
        $countArgs = func_num_args();
        $arg = func_get_args();
        switch($countArgs)
        {
            //insérer un nouveau film en bdd
            case 1:
                if($arg[0] == 'set'){
                    $query = 'INSERT INTO movieepsi.films (id, titre, auteur, dateSortie) VALUES (NULL, \'titleNotYetDefined\', \'autorNotYetDefined\', 0000);';
                    $this->instance->exec($query);
                    $this->id = $this->instance->lastInsertId();
                    //echo($this->instance->lastInsertId());
                }
            break;

            //récupérer les info d'un film en bdd
            case 2:
                if($arg[0]=='get'){
                    $this->getFullInfoOfBdd($arg[1]);
                }

            break;

            default:
                break;
        }
    }


    public function setTitle($title){

        $query = 'UPDATE movieepsi.films SET titre=? WHERE id=?';
        $prep = $this->instance->prepare($query);
        $prep->bindValue(1, $title, \Dao::PARAM_STR);
        $prep->bindValue(2, $this->id, \Dao::PARAM_INT);
        $prep->execute();
        return $prep->rowCount(); // retourne le nombre d'elements modifié par la requete

    }

    public function getTitle(){
       /* $query ='SELECT titre from movieepsi.films where id=?';
        $prep = $this->instance->prepare($query);
        $prep->bindValue(1, $this->id, \Dao::PARAM_INT);
        $prep->execute();
        return $prep->rowCount();
       */
        return $this->titre;
    }

    public function setAuthor($author){

        $query = 'UPDATE movieepsi.films SET auteur=? WHERE id=? ';
        $prep = $this->$instance->prepare($query);
        $prep->bindValue(1, $author, \Dao::PARAM_STR);
        $prep->bindValue(2, $this->id, \Dao::PARAM_INT);
        $prep->execute();
        return $prep->rowCount(); // retourne le nombre d'elements modifié par la requete

    }

    public function getAuthor(){
        $query ='SELECT auteur from movieepsi.films where id=?';
        $prep = $this->instance->prepare($query);
        $prep->bindValue(1, $this->$id, \Dao::PARAM_INT);
        $prep->execute();
        return $prep->rowCount();
    }

    public function setDate($date){
        $query = 'UPDATE movieepsi.films SET dateSortie=? WHERE id=? ';
        $prep = $this->instance->prepare($query);
        $prep->bindValue(1, $date, \Dao::PARAM_STR);
        $prep->bindValue(2, $this->id, \Dao::PARAM_INT);
        $prep->execute();
        return $prep->rowCount();
    }

    public function getDate(){
        return $this->releaseDate;
    }


    public function getFullInfoOfBdd($id){
        $this->id = $id;
        $query ='SELECT * from movieepsi.films where id=?';
        $prep = $this->instance->prepare($query);
        $prep->bindValue(1, $id, \Dao::PARAM_INT);
        $prep->execute();
        $result = $prep->fetch(\Dao::FETCH_BOTH); //tab a nom de col sql ou a index
        //echo("---------------#".$result['titre']."#---------------");
        $this->titre = $result['titre'];
        $this->releaseDate = $result['dateSortie'];

        return $result;
    }

    public function setFullInfoBddInObj($id){
        $result = getFullInfo($id);
        $this->setTitle($result['titre']);
        return $result;
    }



}
