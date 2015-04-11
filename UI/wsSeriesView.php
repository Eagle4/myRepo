<html>
<head>

</head>
<body>
<p>
Info sur la saison : <br />

</p>
<?php
    for($i = 0; $i < sizeof($objSeriesWs[$i]); $i++) {
        echo '<b>'. $objSeriesWs[$i]->getName() .'</b><ul>';
        echo '  <li>Overview: '. $objSeriesWs[$i]->getOverview() .'</li>';
        echo '  <li>Number of Seasons: '. $objSeriesWs[$i]->getNumSeasons() .'</li>';
        echo '  <li>Seasons: <ul>';
        $seasons = $objSeriesWs[$i]->getSeasons();
        foreach($seasons as $season){
            echo '<li><a href="https://www.themoviedb.org/tv/season/'. $season->getID() .'">Season '. $season->getSeasonNumber() .'</a></li>';
        }
        echo ' </ul></ul>';
        echo '<img src="'. $tmdb->getImageURL('w185') . $objSeriesWs[$i]->getPoster() .'"/><br>...<hr>';

    }
?>    
</body>
</html>