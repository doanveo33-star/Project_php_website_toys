<?php
class DB
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'websitedochoi';

    protected $db;

    public function __construct()
    {
        $this->db = $this->Connect();
    }

    public function Connect()
    {
        try {
            $dsn = 'mysql:host=' . $this->host . ';port=3306;dbname=' . $this->dbname . ';charset=utf8mb4';
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            die("Không thể kết nối database. Vui lòng kiểm tra cấu hình.");
        }
    }
}