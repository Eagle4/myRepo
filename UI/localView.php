
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<p>
    Ma filmothèque : <br />

</p>
<?php
    for($i = 0; $i < sizeof($objFilmBdd); $i++){
        echo('<br> titre : '.$objFilmBdd[$i]->getTitle());
        echo('<br> date de sortie : '.$objFilmBdd[$i]->getDate());
        echo '<br><img src="'.$objFilmBdd[$i]->getImgUrl().'"/></li>';
        echo('<hr>');
    };

?>
</body>
</html>
                                                                                                                                                                                                                                                                                                                                                                                                                     