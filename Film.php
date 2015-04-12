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
    private $imgUrl = NULL;
    private $resume = NULL;
    private $serie = NULL;
    private $nbSaisons = NULL;

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
                    $query = 'INSERT INTO movieepsi.films (id) VALUES (NULL);';
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

    public function  getId(){
        return $this->id;
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

    public function setImgUrl($url){

        $query = 'UPDATE movieepsi.films SET urlImg=? WHERE id=?';
        $prep = $this->instance->prepare($query);
        $prep->bindValue(1, $url, \Dao::PARAM_STR);
        $prep->bindValue(2, $this->id, \Dao::PARAM_INT);
        $prep->execute();
        return $prep->rowCount(); // retourne le nombre d'elements modifié par la requete
    }

    public function getImgUrl(){
        return $this->imgUrl;
    }

    public function isSerie(){
        return $this->serie;
    }

    public function setSerie($serie){
        if($serie== true or $serie==false or $serie== 'true' or $serie=='false'){
            $query = 'UPDATE movieepsi.films SET serie=? WHERE id=?';
            $prep = $this->instance->prepare($query);
            $prep->bindValue(1, $serie, \Dao::PARAM_BOOL);
            $prep->bindValue(2, $this->id, \Dao::PARAM_INT);
            $prep->execute();
            return $prep->rowCount(); // retourne le nombre d'elements modifié par la requete
        }else{
            return -1;
        }

    }

    public function getResume(){
        return $this->resume;
    }

    public function setResume($resume){
        $query = 'UPDATE movieepsi.films SET resume=? WHERE id=? ';
        $prep = $this->instance->prepare($query);
        $prep->bindValue(1, $resume, \Dao::PARAM_STR);
        $prep->bindValue(2, $this->id, \Dao::PARAM_INT);
        $prep->execute();
        return $prep->rowCount();
    }


    public function setnbSaisons($nbSaisons){
        $query = 'UPDATE movieepsi.films SET nbSaisons=? WHERE id=? ';
        $prep = $this->instance->prepare($query);
        $prep->bindValue(1, $nbSaisons, \Dao::PARAM_STR);
        $prep->bindValue(2, $this->id, \Dao::PARAM_INT);
        $prep->execute();
        return $prep->rowCount();
    }

    public function getnbSaisons(){

        return $this->nbSaisons;
    }

    public function getFullInfoOfBdd($id){
        $this->id = $id;
        $query ='SELECT * from movieepsi.films where id=?';
        $prep = $this->instance->prepare($query);
        $prep->bindValue(1, $id, \Dao::PARAM_INT);
        $prep->execute();
        $result = $prep->fetch(\Dao::FETCH_BOTH); //tab a nom de col sql ou a index
        $this->titre = $result['titre'];
        $this->releaseDate = $result['dateSortie'];
        $this->imgUrl = $result['urlImg'];

        return $result;
    }

    public function setFullInfoBddInObj($id){
        $result = getFullInfo($id);
        $this->setTitle($result['titre']);
        return $result;
    }





}
