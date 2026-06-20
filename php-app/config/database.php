<?php

class BaseDeDatos {
    private static $instancia = null;
    private $conexion;

    private function __construct() {
        $host = '127.0.0.1';
        $port = '5432';
        $dbname = 'control_actividades';
        $usuario = 'postgres';
        $password = 'Osito123.';

        try {
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
            $this->conexion = new PDO($dsn, $usuario, $password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error de conexion: " . $e->getMessage());
        }
    }

    public static function obtenerInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new BaseDeDatos();
        }
        return self::$instancia;
    }

    public function getConexion() {
        return $this->conexion;
    }
}
