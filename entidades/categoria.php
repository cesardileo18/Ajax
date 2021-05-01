<?php

class Categoria {
    private $idcategoria;
    private $nombre;

    public function __construct(){

    }

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
        return $this;
    }


     public function obtenerTodos(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT id, nombre FROM categorias ORDER BY nombre ASC";
        if (!$resultado = $mysqli->query($sql)) {
                    printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $aResultado = array();
        if($resultado){
            while ($fila = $resultado->fetch_assoc()) {
                $obj = new Categoria();
                $obj->idcategoria = $fila["id"];
                $obj->nombre = $fila["nombre"];
                $aResultado[] = $obj;

            }
            $mysqli->close();
            return $aResultado;
        }
    }


    public function insertar(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $mysqli->set_charset("utf8");
        $sql = "INSERT INTO categorias (nombre) VALUES (
                    '" . $this->nombre ."'
                );";
        if (!$mysqli->query($sql)) {
            return false;
        }
        $this->idcategoria = $mysqli->insert_id;
        return true;
        $mysqli->close();
    }


    public function actualizar(){

        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "UPDATE categorias SET
                nombre = '".$this->nombre."'
                WHERE id = " . $this->idcategoria;
          
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        return true;
        $mysqli->close();
    }

    public function eliminar($idcategoria){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "DELETE FROM categorias WHERE id = " . $idcategoria;
        if (!$mysqli->query($sql)) {
            return false;
        }
        return true;

        $mysqli->close();
    }
}


?>