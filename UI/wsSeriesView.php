<html>
<head>

</head>
<body>
<p>
Info sur la saison : <br />

</p>
<?php
    for($i = 0; $i < sizeof($objSeriesWs[$i]); $i++) {
        $id = $objSeriesWs[$i]->getId();
        $name = $objSeriesWs[$i]->getName();
        $resume = $objSeriesWs[$i]->getOverview();
        $numberOfSeasons = $objSeriesWs[$i]->getNumSeasons();
        $imgUrl = $tmdb->getImageURL('w185') . $objSeriesWs[$i]->getPoster();

        echo '<b>'. $name .'</b><ul>';
        echo '  <li>Résumé: '. $resume .'</li>';
        echo '  <li>Nombre de saison: '. $numberOfSeasons .'</li>';
        echo '  <li>Saison(s): <ul>';
        $seasons = $objSeriesWs[$i]->getSeasons();
        foreach($seasons as $season){
            echo '<li><a href="https://www.themoviedb.org/tv/season/'. $season->getID() .'">Season '. $season->getSeasonNumber() .'</a></li>';
        }
        echo ' </ul></ul>';
        echo '<img src="'.$imgUrl.'"/><br>';
        echo '<form action="controler.php" method="POST" accept-charset="utf-8">';
        echo '<br><button type="submit" value="'.$id.'|'.$name.'|'.$imgUrl.'|serie|'.$resume.'|'.$numberOfSeasons.'" name="addMovie">Ajouter ce film à ma bibliothèque</button></form>';
        echo '<hr>';
    }
?>    
</body>
</html>

