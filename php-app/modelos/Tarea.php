<?php

require_once __DIR__ . '/../config/database.php';

class Tarea {
    private $db;

    public function __construct() {
        $this->db = BaseDeDatos::obtenerInstancia()->getConexion();
    }

    public function obtenerTodas($usuario_id) {
        $sql = "SELECT id, titulo, descripcion, estado, fecha_creacion, fecha_actualizacion
                FROM tareas WHERE usuario_id = :usuario_id ORDER BY fecha_creacion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerPorId($id, $usuario_id) {
        $sql = "SELECT id, titulo, descripcion, estado, fecha_creacion, fecha_actualizacion
                FROM tareas WHERE id = :id AND usuario_id = :usuario_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function crear($titulo, $descripcion, $usuario_id) {
        $sql = "INSERT INTO tareas (titulo, descripcion, usuario_id, estado, fecha_creacion, fecha_actualizacion)
                VALUES (:titulo, :descripcion, :usuario_id, 'pendiente', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function actualizar($id, $titulo, $descripcion, $estado, $usuario_id) {
        $sql = "UPDATE tareas SET titulo = :titulo, descripcion = :descripcion, estado = :estado,
                fecha_actualizacion = CURRENT_TIMESTAMP WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function eliminar($id, $usuario_id) {
        $sql = "DELETE FROM tareas WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
