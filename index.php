<?php
require_once __DIR__ . '/models/Usuario.php';
require_once __DIR__ . '/models/Foto.php';

$foto = new Foto();
$foto->usuarios_id = 1;
$foto->titulo = "Atardecer en la playa";
$foto->descripcion = "Una hermosa vista del atardecer en la playa.";
$foto->fecha_subida = date('Y-m-d H:i:s');
$foto->save();

var_dump(Foto::all());