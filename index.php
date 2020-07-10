<?php

include "data.php";
include "calcula_distancias.php";

//If set, get the origin
if (!empty($_GET["city1"])){
    $city_1 = $_GET["city1"];
}

//If set, get the destination
if (!empty($_GET["city2"])){
    $city_2 = $_GET["city2"];
}


if(!isset($city_1)){
    
    //A message will be shown if there is no origin
    echo "Tienes que indicar al menos una ciudad!";
}elseif(isset($city_1) && isset($city_2)){
    
    //If there are an origin and destination, the disntance will be calculated
    list($path, $total_weight) = calcula_distancias($cities, $connections, $city_1, $city_2);
    message($city_1, $city_2, $path, $total_weight);
}else{
    
    //If there is no destination, the distance will be calculated between the origin and all places listed in the data file
    foreach($cities as $city_2){
        //The origin place is filtered so it doesn't calcule the distance with itself
        if($city_1 == $city_2){
            continue;
        }
        list($path, $total_weight) = calcula_distancias($cities, $connections, $city_1, $city_2);
        message($city_1, $city_2, $path, $total_weight);
    }
}


//Result message to show on the browser
function message($city_1, $city_2, $path, $total_weight){
    
    echo "El camino óptimo entre ".$city_1." y ".$city_2." viene definido por: <br /><br />";
    foreach($path as $element){
        echo " *Tramo ". $element["Origen"]." - ".$element["Destino"].", con distancia: ".$element["Distancia"]."<br />";
    }
    echo "<br />Con una distancia total de: ".$total_weight."<br /><br /><br />";
}

?>