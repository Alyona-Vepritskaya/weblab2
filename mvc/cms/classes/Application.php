<?php // +-
include_once '../init.php';

class Application
{
    protected $router;
    protected $db;
    public static $userSession;

    public function __construct(){
        $this->router = null;
        $this->db = MyDB::get_db_instance();
        self::$userSession = new UserSessions();
    }

    public function run(){
        $this->router = new Route();
        $this->router->route();
    }

    public static function getUserSes(){
        return self::$userSession;
    }

    public static function error404(){
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404<br>Page not found !!!</h1>";
        exit();
    }

}