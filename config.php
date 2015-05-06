<?php
session_start();
//unset($_SESSION['UserID']);
require_once PATH_TO_ROOT . 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(PATH_TO_ROOT . 'templates');
$twig = new Twig_Environment($loader);
class DB
{
    private static $instance = null;

    private static $user = 'root';
    private static $password = '';
    private static $host = 'localhost';
    private static $dbname = 'meltest';

    public static function get()
    {
        if (self::$instance == null) {
            try {
                self::$instance = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname, self::$user, self::$password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->exec("set names utf8");
            } catch (PDOException $e) {
                // Handle this properly
                throw $e;
            }
        }
        return self::$instance;
    }

    public function select($query)
    {
        try {
            //$sth = DB::get()->prepare("SELECT Name, Comment, Date, Time FROM comment ORDER BY ID DESC");
            $sth = $this->get()->prepare($query);
            $sth->execute();

            return $result = $sth->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            //echo "Database error: " . $e->errorInfo[1];
            $db = null;
            exit;
        }
    }

    public function count($table, $where = "")
    {
        $sql = "SELECT COUNT(*) FROM " . $table . " WHERE " . $where;
        if ($res = $this->get()->query($sql)) {
            return $res->fetchColumn();
        }
        else
            return false;
    }

    public function insert($table, $into = array()){
        try {

            foreach ($into as $key => $value){
                ${$key} = $value;
                $fields[] = $key;
                $values[] = ":" . $key;
            }
            $stmt = $this->get()->prepare("INSERT INTO " . $table . " (" . implode(',', $fields) . ") VALUES (" . implode(',', $values) . ")");

            foreach ($into as $key => $value){
                $stmt->bindParam(':' . $key, ${$key});
                ${$key} = $value;

            }

            $stmt->execute();
            $db = null;
            return $this->get()->lastInsertId();

        }
        catch(PDOException $e) {
            echo $e->getMessage();
            echo "err";
            $db = null;
            exit;
        }
    }
}
?>