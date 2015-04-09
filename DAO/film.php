<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 03/04/2015
 * Time: 11:51
 */

namespace film;
require_once('model.php');


class film extends DAO {

    private $instance = null;
    private $id = null;

    public function __construct() {
        $this -> $instance =  DAO::getInstance();
        $query = 'INSERT INTO movieepsi.films (id, titre, auteur, dateSortie) VALUES (NULL, titleNotYetDefined, autorNotYetDefined, 0000);';
        $this->$instance.exec($query);
        $this->$id = $instance.lastInsertId();
    }

    public function setTitle($title){

        $query = 'UPDATE movieepsi.films SET titre=? WHERE id=? ';
        $prep = $this->$instance->prepare($query);
        $prep->bindValue(1, $title, PDO::PARAM_STR);
        $prep->bindValue(2, $this->$id, PDO::PARAM_INT);
        $prep->execute();
        return $prep->rowCount(); // retourne le nombre d'elements modifié par la requete

    }

    public function getTitle(){
        $query ='SELECT titre from movieepsi.films where id=?';
        $prep = $this->$instance->prepare($query);
        $prep->bindValue(1, $this->$id, PDO::PARAM_INT);
        $prep->execute();
        return $prep->rowCount();
    }

    public function setAuthor($author){

        $query = 'UPDATE movieepsi.films SET auteur=? WHERE id=? ';
        $prep = $this->$instance->prepare($query);
        $prep->bindValue(1, $author, PDO::PARAM_STR);
        $prep->bindValue(2, $this->$id, PDO::PARAM_INT);
        $prep->execute();
        return $prep->rowCount(); // retourne le nombre d'elements modifié par la requete

    }

    public function getAuthor(){
        $query ='SELECT auteur from movieepsi.films where id=?';
        $prep = $this->$instance->prepare($query);
        $prep->bindValue(1, $this->$id, PDO::PARAM_INT);
        $prep->execute();
        return $prep->rowCount();
    }



}
