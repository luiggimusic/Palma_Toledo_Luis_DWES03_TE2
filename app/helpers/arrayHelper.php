<?php

    // Con esta función pretendo pasar el array de objetos y que devuelva el objeto si lo encuentra o null si no.
    function getById($dataArray,$id)
    {
        foreach ($dataArray as $data) {
            if ($data['id'] === $id) {
                $data = json_encode($data);
                return $data;
                break;
            }
        }
        return null;
    }

function nextId($dataArray){
    $ids = array_column($dataArray, 'id'); // Extraigo los IDs de su columna
    return empty($ids) ? 1 : max($ids) + 1; // Aquí me he animado a poner la estructura condicional con operador ternario

}