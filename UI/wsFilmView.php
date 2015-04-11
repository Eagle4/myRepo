
<html>
<head>

</head>
<body>
<p>
Info sur le film : <br />

</p>
<?php
    for($i = 0; $i < sizeof($objFilmWs); $i++) {
        echo '  <li>' . $objFilmWs[$i]->getTitle() . ' (<a href="https://www.themoviedb.org/movie/' . $objFilmWs[$i]->getID() . '"> En savoir plus</a>)</li>';
        echo '  <li>Date de sortie:' . date("d-m-Y", strtotime($objFilmWs[$i]->get('release_date'))) . '</li>';
        echo '  <li>Tagline:' . $objFilmWs[$i]->getTagline() . '</li>';
        if ($objFilmWs[$i]->getTrailer() == 'non disponible') {
            echo '  <li>Trailer: non disponible </li>';
        } else {
            echo '  <li>Trailer: <a href="https://www.youtube.com/watch?v=' . $objFilmWs[$i]->getTrailer() . '">Voir le trailer</a></li>';
        }
        //echo'  <li>Résumé:'. $objFilmWs[$i]->get('overview') .'</li>';
        echo '</ul>...';
        echo '<img src="' . $tmdb->getImageURL('w185') . $objFilmWs[$i]->getPoster() . '"/></li>';
        echo '<form action="controler.php" method="POST" accept-charset="utf-8">';
        $id = $objFilmWs[$i]->getId();
        echo($id);
        echo '<br><button type="submit" value="'.$id.'|'.$objFilmWs[$i]->getTitle().'|'.$objFilmWs[$i]->get('release_date').'" name="addMovie">Ajouter ce film à ma bibliothèque</button></form>';
    }
?>    
</body>
</html>
