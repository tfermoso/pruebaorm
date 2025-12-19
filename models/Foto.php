<?php
require_once __DIR__ . '/../core/Model.php';

class Foto extends Model {

    protected static $table = 'fotos';
    protected static $primaryKey = 'fotos_id';

    public $usuarios_id;
    public $titulo;
    public $descripcion;
    public $fecha_subida;
}