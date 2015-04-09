<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 08/04/2015
 * Time: 12:03
 */

require('Film.php');


if (isset($_POST['filmTitle'])) {
    echo($_POST['filmTitle']);
    //$objfilm  = new \Film\Film('get',25);
    //$objfilm->setTitle($_POST['filmTitle']);

    $instance = \Dao::getInstance();
    $query = 'select * from movieepsi.films where titre=?';
    $prep = $instance->prepare($query);
    $prep->bindValue(1,$_POST['filmTitle'], \Dao::PARAM_STR);
    $prep->execute();
    $result = $prep->fetchAll(\Dao::FETCH_BOTH);
    print_r($result);
    $countRet = $prep->rowCount();
    //echo($prep->rowCount());

    if($countRet != 0){ // si film déja en bdd
        //afficher info du film
        for($i = 0; $i <= $countRet-1; $i++){
            echo($result[0]['id']);
            $objfilm  = new \Film\Film('get',$result[$i]['id']);
            echo("titre film de l'objet en cours".$objfilm->getTitle());
        }


    }else{ // si film pas en bdd
        //recherche par webservice
        require_once('tmdb-api.php');
        $apikey = "470fd2ec8853e25d2f8d86f685d2270e";
        $tmdb = new TMDB($apikey, 'fr', true);
        echo '<ol><li><a id="searchMovie"><h3>Search Movie</h3></a><ul>';
        $movies = $tmdb->searchMovie($_POST['filmTitle']);
        foreach($movies as $movie){
            echo '<li>'. $movie->getTitle() .' (<a href="https://www.themoviedb.org/movie/'. $movie->getID() .'">'. $movie->getID() .'</a>)</li>';
        }
    }
}

