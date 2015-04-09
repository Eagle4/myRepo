<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 08/04/2015
 * Time: 12:03
 */

require('Film.php');


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
        for($i = 0; $i <= $countRet-1; $i++){
            //echo($result[0]['id']);
            $objfilm  = new \Film\Film('get',$result[$i]['id']);
            //echo("titre film de l'objet en cours".$objfilm->getTitle());
        }


    }else{ // si film pas en bdd
        //recherche par webservice
        require_once('tmdb-api.php');
        $apikey = "470fd2ec8853e25d2f8d86f685d2270e";
        $tmdb = new TMDB($apikey, 'fr', true);

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
            echo '<li><button type="submit" name="addMovie">Ajouter ce film à ma bibliothèque</button></li>';
            $objfilm  = new \Film\Film('set');
            $objfilm->setTitle($movie->getTitle());
            $objfilm->setDate($movie->get('release_date'));
        }




    }
}

