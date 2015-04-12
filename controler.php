<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 08/04/2015
 * Time: 12:03
 */

require('Film.php');

if(isset($_POST['seeMoviesLibrary'])){
    $instance = \Dao::getInstance();
    $query = 'select id from movieepsi.films';
    $prep = $instance->prepare($query);
    $prep->execute();
    $result = $prep->fetchAll(\Dao::FETCH_BOTH);
    for($i = 0; $i < sizeof($result); $i++) {
        $objFilmBdd[$i] = new \Film\Film('get',$result[$i][0]);
    }
    include('ui\localView.php');
}

if(isset($_POST['addMovie'])){
    $data = explode('|',$_POST['addMovie']);
    print_r($data);
    $objfilm  = new \Film\Film('set');
    if($data[3] == 'film'){
        $objfilm->setTitle($data[1]);
        $objfilm->setImgUrl($data[2]);
        $objfilm->setResume($data[4]);
        $objfilm->setDate($data[5]);
    }else if($data[3] == 'serie'){
        $objfilm->setTitle($data[1]);
        $objfilm->setImgUrl($data[2]);
        $objfilm->setSerie(true);
        $objfilm->setResume($data[4]);
        $objfilm->setNbSaisons($data[5]);
    }
    $objFilmBdd[0] = new \Film\Film('get',$objfilm->getId());
    include('ui\localView.php');
}

if (isset($_POST['filmTitle'])) {
    echo ('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">');
    $instance = \Dao::getInstance();
    $query = 'select * from movieepsi.films where titre=?';
    $prep = $instance->prepare($query);
    $prep->bindValue(1,$_POST['filmTitle'], \Dao::PARAM_STR);
    $prep->execute();
    $result = $prep->fetchAll(\Dao::FETCH_BOTH);
    //print_r($result);
    $countRet = $prep->rowCount();
    //echo($prep->rowCount());
    if($countRet != 0){ // si film déja en bdd
        //afficher info du film
        for($i = 0; $i < $countRet; $i++){
            $objfilm  = new \Film\Film('get',$result[$i]['id']);
            $objFilmBdd[$i] = $objfilm;
        }
        include('ui\localView.php');

    }else{ // si film pas en bdd
        //recherche par webservice
        require_once('tmdb-api.php');
        $apikey = "470fd2ec8853e25d2f8d86f685d2270e";
        $tmdb = new TMDB($apikey, 'fr', true);

        switch($_POST['typeOfSearch'])
        {

            case 1:
                $movies =  $tmdb->searchMovie($_POST['filmTitle']);
                $i = 0;
                foreach($movies as $movie) {
                    $movie = $tmdb->getMovie($movie->getID());
                    $objFilmWs[$i] = $movie;
                    $i++;
                }
                include('ui\wsFilmView.php');
                break;


            case 2:
                $series = $tmdb->searchTVShow($_POST['filmTitle']);
                $i = 0;
                foreach($series as $serie){
                    $serie = $tmdb->getTVShow($serie->getID());
                    $objSeriesWs[$i] = $serie;
                    $i++;
                }
                include('ui\wsSeriesView.php');
                break;

            default:
                break;
        }



/*
        echo '<li><a id="movieInfo"><h3>Full Movie Info</h3></a>';

        $movies =  $tmdb->searchMovie($_POST['filmTitle']);
        foreach($movies as $movie){
            $movie = $tmdb->getMovie($movie->getID());
            echo '  <li>'. $movie->getTitle() .' (<a href="https://www.themoviedb.org/movie/'. $movie->getID() .'"> En savoir plus</a>)</li>';
            echo'  <li>Date de sortie:'.  date("d-m-Y", strtotime($movie->get('release_date'))) .'</li>';
            echo '  <li>Tagline:'. $movie->getTagline() .'</li>';
            if($movie->getTrailer()=='non disponible'){
                echo '  <li>Trailer: non disponible </li>';
            }else{
                echo '  <li>Trailer: <a href="https://www.youtube.com/watch?v='. $movie->getTrailer() .'">Voir le trailer</a></li>';
            }
            //echo'  <li>Résumé:'. $movie->get('overview') .'</li>';
            echo '</ul>...';
            echo '<img src="'. $tmdb->getImageURL('w185') . $movie->getPoster() .'"/></li>';
            echo '<br><button type="submit" name="addMovie">Ajouter ce film à ma bibliothèque</button>';
            $objfilm  = new \Film\Film('set');
            $objfilm->setTitle($movie->getTitle());
            $objfilm->setDate($movie->get('release_date'));
        }

*/


    }
}

