<?php

//======================================================================
// Distances calculator library
//======================================================================


/*
    General function to get the minimum distance bettwen to cities
    
    Params:
        $cities: array of places (strings)
        $connections: multi-dimenssional array with the distances between places
        $city1: Origin place
        $city2: Destination place
    
    Return: List of two elements, an array of paths with origin, destination and distance between them, and the total (minimum) distance.
*/
function calcula_distancias($cities, $connections, $city1, $city2){
    
    $combinations = cities_combinations($cities, $city1);
    
    $combinations = limit_combinations($combinations, $city2);
    
    $list = get_weight($combinations, $cities, $connections);
    
    return $list;
}


/*
    Get the position of the place in the array
    
    Params:
        $city: Place to look for
        $cities: array of places (strings)
        
    Return:
        Position of the place in the array (Integer)
*/
function get_city_position($city, $cities){
    
    return array_search($city, $cities);
}


/*
    Get the name of the place with a specific position in the array
    
    Params:
        $position: Position in the array of the place
        $cities: array of places (strings)
        
    Return:
        Name of the place (String)
*/
function get_city_name($position, $cities){
    
    return $cities[$position];
}


/*
    Calcule all combination of places
    
    Params:
        $cities: array of places (strings)
        $city1: Origin
        
    Return:
        List of strings with all possible paths
*/
function cities_combinations($cities, $city1="") {
    if(!empty($city1)){
        $city_position = get_city_position($city1, $cities);
        array_splice($cities, $city_position, 1);
    }
    
    if (count($cities) <= 1){
        
        $result = $cities;
    }else{
        
        $result = array();
        for($i = 0;$i < count($cities); ++$i){
            
            $rest = array();
            $city = $cities[$i];
            
            for ($j = 0; $j < count($cities); ++$j){
                if ($i != $j){
                    $rest[] = $cities[$j];
                }
            }
            $temp = cities_combinations($rest);
            for ($j = 0; $j < count($temp); ++$j){
                $result[] = $city . $temp[$j];
            }
        }
    }
    
    for($i=0; $i<count($result);$i++){
        $result[$i] = $city1."_".$result[$i];
    }
    return $result;
}


/*
    Limit all combinations until the destination place and removes duplicates
    
    Params:
        $combinations: All possible combination of places
        $city2: Destination place
        
    Return:
        List of strings with all possible paths
*/
function limit_combinations($combinations, $city2){
    
    $array = array();
    
    foreach($combinations as $combination){
        
        $array_inter = explode("_",$combination);
        $array_inter = array_slice($array_inter, 0, array_search($city2, $array_inter)+1);
        
        if(!in_array($array_inter, $array)){
            $array[] = $array_inter;
        }
    }
    
    return $array;
}


/*
    Calcule the minimum distance between places and its path
    
    Params:
        $combinations: All possible combination of places already filtered
        $cities: array of places (strings)
        
    Return:
        List of two elements, an array of paths with origin, destination and distance between them, and the total (minimum) distance.
*/
function get_weight($combinations, $cities, $connections){
    
    $result = array();
    $last_min = NULL;
    foreach($combinations as $combination){
        
        $array = array();
        $total_weight = 0;
        for($i=0; $i<(count($combination)-1); $i++){
            
            $first_position = get_city_position($combination[$i], $cities);
            $second_position = get_city_position($combination[$i+1], $cities);
            
            if($connections[$first_position][$second_position] == 0){
                continue 2;
            }else{
                $array[] = array("Origen" => $combination[$i],
                                "Destino" => $combination[$i+1],
                                "Distancia" => $connections[$first_position][$second_position]);
                $total_weight = $total_weight + $connections[$first_position][$second_position];
            }
        }
        
        if(empty($result)){
            $result = $array;
            $last_min = $total_weight;
        }else{
            if($last_min>$total_weight){
                $result = $array;
                $last_min = $total_weight;
            }
        }
    }
    
    return array($result, $last_min);
}


?>