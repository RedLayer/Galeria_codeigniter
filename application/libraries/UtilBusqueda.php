<?php
class UtilBusqueda{
    
     
    //Buscar en array de objetos un objeto, en función de valor de columna
    public static function buscarEnArray($array, $nombrecolumna, $valor)
    {
        foreach($array as $arrayPos) {
            if($arrayPos->{$nombrecolumna} == $valor) {
                return $arrayPos;
            }
        }
        return null;
    }
    
}

