<?php

class Producto {
    private $idproducto;
    private $nombre;
    private $fk_idcategoria;
    private $precio;
    private $fecha_subido;

    public function __construct(){
            $this->precio = 0.0;
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
        $sql = "SELECT id, nombre, fk_idcategoria, precio, fecha_subido FROM productos ORDER BY nombre ASC";
        if (!$resultado = $mysqli->query($sql)) {
                    printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $aResultado = array();
        if($resultado){
            while ($fila = $resultado->fetch_assoc()) {
                $obj = new Producto();
                $obj->idproducto = $fila["id"];
                $obj->nombre = $fila["nombre"];
                $obj->fk_idcategoria = $fila["fk_idcategoria"];
                $obj->precio = $fila["precio"];
                $obj->fecha_subido = $fila["fecha_subido"];
                $aResultado[] = $obj;

            }
            $mysqli->close();
            return $aResultado;
        }
    }


    public function insertar(){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $mysqli->set_charset("utf8");
        $sql = "INSERT INTO productos (
            nombre, 
            fk_idcategoria, 
            precio, 
            fecha_subido
        ) VALUES (
            '" . $this->nombre ."', 
            '" . $this->fk_idcategoria ."', 
            '" . $this->precio ."', 
            '" . $this->fecha_subido ."'
        );";
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            return false;
        }
        //Obtiene el id generado por la inserción
        
        //Cierra la conexión
        $mysqli->close();
        return true;
        }
       
       
    public function actualizar(){
   
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "UPDATE productos SET
                nombre = '".$this->nombre."',
                fk_idcategoria = '".$this->fk_idcategoria."',
                precio = '".$this->precio."',
                fecha_subido = '".$this->fecha_subido."'
                WHERE id = " . $this->idproducto;
               
               if (!$mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . "Error en actualizar " . $sql);
            }
            return true;
            $mysqli->close();
    }

    public function eliminar($idproducto){
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "DELETE FROM productos WHERE id = " . $idproducto;
        if (!$mysqli->query($sql)) {
            return false;
        }
        return true;

        $mysqli->close();
    }
}


?>