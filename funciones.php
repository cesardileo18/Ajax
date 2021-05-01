<?php
include_once("config.php");
include_once("entidades/categoria.php");
include_once("entidades/producto.php");

/*********************************************** 
 *             CATEGORIAS                       *
 ***********************************************/



/* 

 En la 1ras lineas de codigo agregamos las entidades (modelos o clases, como decidas llamarlo) correspondientes (En el caso de usarlas)
 En gral se verifica que por metodo (get o post) y se revisa que funcion ejecutar.



 */

if (isset($_POST["do"]) && $_POST["do"] == "actualizarCategoria") { // si existe alguna petision por metodo post yy la accion (do) a realizar es "actualizarCategoria", ejecutas esta accion

    $return = array();
    $return["msj"] = "";
    $return["success"] = true;

    /*
     IMPORTANTE-> cuando ejecutamos el ajax le en el atributo dataType seleccionamos 'json' por lo cual el resultado de la funcion ejecutada en el post o get tiene que ser un json... 
     Lo que hago en este caso es crear un array para luego convertirlo en json y que no haya problema.

     por este motivo creo la variable $return del tio array
     alfinalizar la funcion utilizo  echo json_encode($return);

     json_encode lo utilizo para convertir el array en json y con echo lo imprimo para devolverlo al ajax
    */
    $categoria = new Categoria(); // creo el objeto de clase categoria
    $categoria->idcategoria = $_POST["id"];
    $categoria->nombre = $_POST["nombre"];

    if (!($categoria->actualizar())) { // ejecuto la funcion actualizar de la clase categoria.
        $return["msj"] = "Hubo un error. (err01)";
        $return["success"] = false;
    }


    echo json_encode($return);
    exit;
} // END actualizarCategoria


if (isset($_POST["do"]) && $_POST["do"] == "borrarCategoria") {

    $return = array();
    $return["msj"] = "";
    $return["success"] = true;


    $categoria = new Categoria();
    $categoria->idcategoria = $_POST["id"];

    if (!($categoria->eliminar($_POST["id"]))) {
        $return["msj"] = "Hubo un error. (err01)";
        $return["success"] = false;
    }


    echo json_encode($return);
    exit;
} // END borrarCategoria



if (isset($_GET["do"]) && $_GET["do"] == "cargarGrillaCategorias") {
    $categoria = new Categoria();
    $aCategorias = $categoria->obtenerTodos();

    $data = array();

    if (count($aCategorias) > 0) {
        for ($i = 0; $i < count($aCategorias); $i++) {
            $row = array();

            $row[] = $aCategorias[$i]->idcategoria;
            $row[] = $aCategorias[$i]->nombre;
            $row[] = "<button class='btn btn-primary mx-1 btn-edit' onclick='editarCategoria(this)' data-id='" . $aCategorias[$i]->idcategoria . "'  data-nombre='" . $aCategorias[$i]->nombre . "'><i class='fas fa-pen-square'></i></button> <button class='btn btn-danger btn-delete mx-1' onclick='deleteCategoria(this)' data-id='" . $aCategorias[$i]->idcategoria . "'  data-nombre='" . $aCategorias[$i]->nombre . "'><i class='fas fa-trash'></i></button>";
            $data[] = $row;
        }
        $json_data = array(
            "draw" => isset($request['draw']) ? intval($request['draw']) : 0,
            "recordsTotal" => count($aCategorias), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aCategorias), //cantidad total de registros en la paginacion
            "data" => $data
        );
        echo json_encode($json_data);
    } else {
        $json_data = array(
            "data" => []
        );
        echo json_encode($json_data);
    }
} // END cargarGrillaCategorias


if (isset($_POST["do"]) && $_POST["do"] == "guardarNuevaCategoria") {

    $return = array();
    $return["msj"] = "";
    $return["success"] = true;

    $categoria = new Categoria();
    $categoria->nombre = $_POST["nombre"];


    if (!($categoria->insertar())) {
        $return["msj"] = "Hubo un error. (err01)";
        $return["success"] = false;
    }

    echo json_encode($return);
    exit;
} // END guardarNuevaCategoria

/*********************************************** 
 *            END CATEGORIAS                    *
 ***********************************************/

 /*********************************************** 
 *             PRODUCTOS                       *
 ***********************************************/



/* 

 En la 1ras lineas de codigo agregamos las entidades (modelos o clases, como decidas llamarlo) correspondientes (En el caso de usarlas)
 En gral se verifica que por metodo (get o post) y se revisa que funcion ejecutar.



 */

if (isset($_POST["do"]) && $_POST["do"] == "actualizarProducto") { // si existe alguna petision por metodo post yy la accion (do) a realizar es "actualizarCategoria", ejecutas esta accion

    $return = array();
    $return["msj"] = "";
    $return["success"] = true;
    /*
     IMPORTANTE-> cuando ejecutamos el ajax le en el atributo dataType seleccionamos 'json' por lo cual el resultado de la funcion ejecutada en el post o get tiene que ser un json... 
     Lo que hago en este caso es crear un array para luego convertirlo en json y que no haya problema.

     por este motivo creo la variable $return del tio array
     alfinalizar la funcion utilizo  echo json_encode($return);

     json_encode lo utilizo para convertir el array en json y con echo lo imprimo para devolverlo al ajax
    */
    $producto = new Producto(); // creo el objeto de clase pr$producto
    $producto->idproducto = $_POST["id"];
    $producto->nombre = $_POST["nombre"];
    $producto->precio = $_POST["precio"];
    $producto->fk_idcategoria = $_POST["fk_idcategoria"];
    $producto->fecha_subido = $_POST["fecha_subido"];

    if (!($producto->actualizar())) { // ejecuto la funcion actualizar de la clase categoria.
        $return["msj"] = "Hubo un error. (err01)";
        $return["success"] = false;
    }


    echo json_encode($return);
    exit;
} // END actualizarCategoria


if (isset($_POST["do"]) && $_POST["do"] == "borrarProducto") {

    $return = array();
    $return["msj"] = "";
    $return["success"] = true;


    $producto = new Producto();
    $producto->idproducto = $_POST["id"];

    if (!($producto->eliminar($_POST["id"]))) {
        $return["msj"] = "Hubo un error. (err01)";
        $return["success"] = false;
    }


    echo json_encode($return);
    exit;
} // END borrarCategoria



if (isset($_GET["do"]) && $_GET["do"] == "cargarGrillaProductos") {
    $producto = new Producto();
    $aProductos = $producto->obtenerTodos();

    $data = array();

    if (count($aProductos) > 0) {
        for ($i = 0; $i < count($aProductos); $i++) {
            $row = array();

            $row[] = $aProductos[$i]->idproducto;
            $row[] = $aProductos[$i]->nombre;
            $row[] = $aProductos[$i]->fk_idcategoria;
            $row[] = $aProductos[$i]->precio;
            $row[] = $aProductos[$i]->fecha_subido;
            $row[] = "<button class='btn btn-primary mx-1 btn-edit' onclick='editarProducto(this)'  data-fecha_subido = '".$aProductos[$i]->fecha_subido."'  data-precio = '".$aProductos[$i]->precio."' data-fk_idcategoria = '".$aProductos[$i]->fk_idcategoria."' data-id='" . $aProductos[$i]->idproducto . "'  data-nombre='" . $aProductos[$i]->nombre . "'><i class='fas fa-pen-square'></i></button> <button class='btn btn-danger btn-delete mx-1' onclick='deleteProducto(this)' data-precio = '".$aProductos[$i]->precio."' data-fk_idcategoria = '".$aProductos[$i]->fk_idcategoria."' data-fecha_subido = '".$aProductos[$i]->fecha_subido."' data-id='" . $aProductos[$i]->idproducto . "'  data-nombre='" . $aProductos[$i]->nombre . "'><i class='fas fa-trash'></i></button>";
            $data[] = $row;
        }
        $json_data = array(
            "draw" => isset($request['draw']) ? intval($request['draw']) : 0,
            "recordsTotal" => count($aProductos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aProductos), //cantidad total de registros en la paginacion
            "data" => $data
        );
        echo json_encode($json_data);
    } else {
        $json_data = array(
            "data" => []
        );
        echo json_encode($json_data);
    }
} // END cargarGrillaCategorias


if (isset($_POST["do"]) && $_POST["do"] == "guardarNuevoProducto") {

    $return = array();
    $return["msj"] = "";
    $return["success"] = true;

    $producto = new Producto();
    $producto->nombre = $_POST["nombre"];
    $producto->fk_idcategoria = $_POST["fk_idcategoria"];
    $producto->precio = $_POST["precio"];
    $producto->fecha_subido = $_POST["fecha_subido"];



    if (!($producto->insertar())) {
        $return["msj"] = "Hubo un error. (err01)";
        $return["success"] = false;
    }

    echo json_encode($return);
    exit;
} // END guardarNuevaCategoria

/*********************************************** 
 *            END PRODUCTOS                    *
 ***********************************************/
