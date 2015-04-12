
<html>
<head>

</head>
<body>
<p>
Info sur le film : <br />

</p>
<?php
    for($i = 0; $i < sizeof($objFilmWs); $i++) {
        $name = $objFilmWs[$i]->getTitle();
        $releaseDate = $objFilmWs[$i]->get('release_date');
        $tagline = $objFilmWs[$i]->getTagline();
        $resume = $objFilmWs[$i]->get('overview');
        $trailer = $objFilmWs[$i]->getTrailer();
        $imgUrl = $tmdb->getImageURL('w185') . $objFilmWs[$i]->getPoster();

        echo '  <li><b>' .$name  . '</b>(<a href="https://www.themoviedb.org/movie/' . $objFilmWs[$i]->getID() . '"> En savoir plus</a>)</li>';
        echo '  <li>Date de sortie:' . date("d-m-Y", strtotime($releaseDate)) . '</li>';
        echo '  <li>Resumé:' . $resume . '</li>';
        if ($trailer == 'non disponible') {
            echo '  <li>Trailer : '.$trailer.' </li>';
        } else {
            echo '  <li>Trailer: <a href="https://www.youtube.com/watch?v=' . $objFilmWs[$i]->getTrailer() . '">Voir le trailer</a></li>';
        }
        echo '</ul>...';
        echo '<img src="' . $imgUrl . '"/></li>';
        echo '<form action="controler.php" method="POST" accept-charset="utf-8">';
        $id = $objFilmWs[$i]->getId();
        echo '<br><button type="submit" value="'.$id.'|'.$name.'|'.$imgUrl.'|film|'.$resume.'|'.$releaseDate.'" name="addMovie">Ajouter ce film à ma bibliothèque</button></form>';
        echo('<hr>');
    }
?>    
</body>
</html>
