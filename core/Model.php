// core/Model.php
require_once __DIR__ . '/../config/database.php';

abstract class Model {

    protected static $table;
    protected static $primaryKey = 'id';
    protected static $db;

    protected static function db() {
        if (!self::$db) {
            self::$db = Database::connect();
        }
        return self::$db;
    }

    // --------------------
    // READ
    // --------------------
    public static function all() {
        $stmt = self::db()->prepare(
            "SELECT * FROM " . static::$table
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function find($id) {
        $stmt = self::db()->prepare(
            "SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = ?"
        );
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetch();
    }

    // --------------------
    // CREATE
    // --------------------
    public function save() {
        $props = get_object_vars($this);
        unset($props[static::$primaryKey]);

        $columns = implode(',', array_keys($props));
        $placeholders = ':' . implode(',:', array_keys($props));

        $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";
        $stmt = self::db()->prepare($sql);
        $stmt->execute($props);

        $this->{static::$primaryKey} = self::db()->lastInsertId();
    }

    // --------------------
    // UPDATE
    // --------------------
    public function update() {
        $props = get_object_vars($this);
        $id = $props[static::$primaryKey];
        unset($props[static::$primaryKey]);

        $fields = [];
        foreach ($props as $key => $value) {
            $fields[] = "$key = :$key";
        }

        $sql = "UPDATE " . static::$table . " SET " . implode(',', $fields)
             . " WHERE " . static::$primaryKey . " = :id";

        $props['id'] = $id;
        $stmt = self::db()->prepare($sql);
        $stmt->execute($props);
    }

    // --------------------
    // DELETE
    // --------------------
    public function delete() {
        $id = $this->{static::$primaryKey};

        $stmt = self::db()->prepare(
            "DELETE FROM " . static::$table . " WHERE " . static::$primaryKey . " = ?"
        );
        $stmt->execute([$id]);
    }
}
