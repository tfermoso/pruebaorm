// models/Usuario.php
require_once __DIR__ . '/../core/Model.php';

class Usuario extends Model {

    protected static $table = 'usuarios';
    protected static $primaryKey = 'usuario_id';

    public $usuario_id;
    public $nombre;
    public $email;
}
