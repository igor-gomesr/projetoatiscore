<?php

class Questionario {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function salvar($dados) {
        $query = "INSERT INTO questionarios 
                  (usuario_id, diasintenso, minutosintenso, diasmoderada, minutosmoderada, 
                   diascaminhada, minutoscaminhada, minutossentado, 
                   metcaminhada, metmoderada, metintenso, mettotal, nivel) 
                  VALUES 
                  (:usuario_id, :diasintenso, :minutosintenso, :diasmoderada, :minutosmoderada,
                   :diascaminhada, :minutoscaminhada, :minutossentado,
                   :metcaminhada, :metmoderada, :metintenso, :mettotal, :nivel)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $dados['usuario_id']);
        $stmt->bindParam(':diasintenso', $dados['diasintenso']);
        $stmt->bindParam(':minutosintenso', $dados['minutosintenso']);
        $stmt->bindParam(':diasmoderada', $dados['diasmoderada']);
        $stmt->bindParam(':minutosmoderada', $dados['minutosmoderada']);
        $stmt->bindParam(':diascaminhada', $dados['diascaminhada']);
        $stmt->bindParam(':minutoscaminhada', $dados['minutoscaminhada']);
        $stmt->bindParam(':minutossentado', $dados['minutossentado']);
        $stmt->bindParam(':metcaminhada', $dados['metcaminhada']);
        $stmt->bindParam(':metmoderada', $dados['metmoderada']);
        $stmt->bindParam(':metintenso', $dados['metintenso']);
        $stmt->bindParam(':mettotal', $dados['mettotal']);
        $stmt->bindParam(':nivel', $dados['nivel']);
        return $stmt->execute();
    }
    
    public function listarPorUsuario($usuario_id) {
        $query = "SELECT * FROM questionarios WHERE usuario_id = :usuario_id ORDER BY data_resposta DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function buscarUltimo($usuario_id) {
        $query = "SELECT * FROM questionarios WHERE usuario_id = :usuario_id ORDER BY data_resposta DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function buscarPorId($id, $usuario_id) {
        $query = "SELECT * FROM questionarios WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>