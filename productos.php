<?php
include_once("config.php");
include_once("entidades/producto.php");
include_once("entidades/categoria.php");


$categoria = new Categoria();
$array_categorias = $categoria->ObtenerTodos();

?>
<?php include('header.php'); ?>
<style>
    .errInput {
        border: 1px solid red;
    }

    #spinnerMdlAdd {
        display: none;
    }
</style>
<link rel="stylesheet" href="css/jquery-confirm.min.css">

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row my-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <i class="fa fa-table"></i> Productos
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalProducto">Agregar</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body p-2">
                    <table id="grilla" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Precio</th>
                                <th>Fecha Subido</th>
                                <th>Herramientas</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <!-- Modal -->
    <div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Productos
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group row mx-1">
                            <label for="txtNombre">Nombre: </label>
                            <input type="text" name="txtNombre" id="txtNombre" class="form-control ">
                        </div>
                        <div class="form-group row mx-1">
                            <label for="txtPrecio">Precio: </label>
                            <input type="text" name="txtPrecio" id="txtPrecio" class="form-control ">
                        </div>
                        <div class="form-group row mx-1">
                             <label for="txtCategoria">Categoria:</label>
                           <select name="txtCategoria" id="txtCategoria" class="form-control">
                              <option disabled selected> Seleccionar </option>
                                <?php foreach ($array_categorias as $categoria) : ?>
                                   <?php if ($producto->fk_idcategoria == $categoria->idcategoria) : ?>
                                    <option selected value="<?php echo $categoria->idcategoria; ?>"><?php echo $categoria->nombre; ?></option>
                                      <?php else : ?>
                                    <option value="<?php echo $categoria->idcategoria; ?>"><?php echo $categoria->nombre; ?></option>
                                       <?php endif; ?>
                               <?php endforeach; ?>
                             </select>
                        </div>
                <div class="form-group row mx-1">
                    <label for="txtFecha">Fecha Subido: </label>
                    <input type="date" name="txtFecha" id="txtFecha" class="form-control ">
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnAgregarNuevo">Agregar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalEdtPro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Productos
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row mx-1 html-mdlEdit">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnActualizar">Actualizar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalDltPro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seguro desea eliminar?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row mx-1 html-mdlDelete">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnDeletePro">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<script>
    window.onload = function() {
        cargarGrilla();

        $('#btnDeletePro').click(function() {
            //VALIDA SI EL FOMRULARIO TIENE ID, SI TIENE ID EJECUTA LA FUNCION borrarCateoria(id) -> dispara un ajax hacia funciones.php y elimina el id que le pasamos por parametro a la funcion.
            let id = $('#txtIdProDlt').val();

            if (id == "" || id == null) {
                $("#modalDltPro").modal("hide");
            }

            if (!(id == "" || id == null)) {
                borrarProducto(id);
            }
        });

        $('#btnActualizar').click(function() {
            //VALIDA SI EL FOMRULARIO TIENE ID Y NOMBRE, SI TIENE TODO EJECUTA LA FUNCION actualizarCategoria(id,nombre) -> dispara un ajax hacia funciones.php y actualiza la categoria por id.
            let nombre = $('#txtNombreEdit').val();
            let precio = $('#txtPrecioEdit').val();
            let fk_idcategoria = $('#txtCategoriaEdit').val();
            let fecha_subido = $('#txtFechaEdit').val();
            let id = $('#txtIdPro').val();

            if (id == "" || id == null) {
                $("#modalEdtPro").modal("hide");
            }

            if (nombre == "" || nombre == null) {
                $('#txtNombreEdit').addClass('errInput');
            } else {
                $('#txtNombreEdit').removeClass('errInput');
            }

            if (precio == "" || precio == null) {
                $('#txtPrecioEdit').addClass('errInput');
            } else {
                $('#txtPrecioEdit').removeClass('errInput');
            }

            if (fk_idcategoria == "" || fk_idcategoria == null) {
                $('#txtCategoriaEdit').addClass('errInput');
            } else {
                $('#txtCategoriaEdit').removeClass('errInput');
            }

            if (fecha_subido == "" || fecha_subido == null) {
                $('#txtFechaEdit').addClass('errInput');
            } else {
                $('#txtFechaEdit').removeClass('errInput');
            }


            if (!(nombre == "" || nombre == null || precio == "" || precio == null || fk_idcategoria == "" || fk_idcategoria == null ||
                    fecha_subido == "" || fecha_subido == null || id == "" || id == null)) {

                actualizarProducto(id, nombre, precio, fk_idcategoria, fecha_subido);
            }
        });

        $('#btnAgregarNuevo').click(function() {
            //VALIDA SI EL FOMRULARIO TIENE  NOMBRE, SI TIENE TODO EJECUTA LA FUNCION guardarNuevoProducto(nombre) -> dispara un ajax hacia funciones.php y agrega la categoria.
            let nombre = $('#txtNombre').val();
            let precio = $('#txtPrecio').val();
            let fk_idcategoria = $('#txtCategoria').val();
            let fecha_subido = $('#txtFecha').val();

            if (nombre == "" || nombre == null) {
                $('#txtNombre').addClass('errInput');
            } else {
                $('#txtNombre').removeClass('errInput');
            }
            if (precio == "" || precio == null) {
                $('#txtPrecio').addClass('errInput');
            } else {
                $('#txtPrecio').removeClass('errInput');
            }
            if (fk_idcategoria == "" || fk_idcategoria == null) {
                $('#txtCategoria').addClass('errInput');
            } else {
                $('#txtCategoria').removeClass('errInput');
            }
            if (fecha_subido == "" || fecha_subido == null) {
                $('#txtFecha').addClass('errInput');
            } else {
                $('#txtFecha').removeClass('errInput');
            }

            if (!(nombre == "" || nombre == null || precio == "" || precio == null || fk_idcategoria == "" || fk_idcategoria == null ||
                    fecha_subido == "" || fecha_subido == null)) {
                guardarNuevoProducto(nombre, precio, fk_idcategoria, fecha_subido);
            }
        });
        $('#txtIdPro').prop('disabled', true);
    }


    function actualizarProducto(id, nombre, precio, fk_idcategoria, fecha_subido) {
        /*
        
        El formData crea un arreglo de datos que luego enviamos en el ajax para realizar la funcion requerida.

        Funciona como un array asociativo.

        formData.append("nombre clave dentro del formdata", "valor a almacenar"); 

        Cada dato que agregamos al form data es deforma opcional... envias los datos que necesitas.
        
        */
        var formData = new FormData(); // creamos form data
        formData.append("do", "actualizarProducto");
        formData.append("id", id);
        formData.append("nombre", nombre);
        formData.append("precio", precio);
        formData.append("fk_idcategoria", fk_idcategoria);
        formData.append("fecha_subido", fecha_subido);

        $.ajax({
            type: 'POST', // type puede ser POST o GET, si enviamos los datos como POST en el php llegan cargados en $_POST y en el caso de type ser GET seria en php $_GET
            url: "funciones.php",
            contentType: false,
            dataType: 'json',
            // IMPORTANTE, al seleccionar dataType como json.. el ajax retornara true solo si la peticion a funciones.php retorna un json, de lo contrario dara error. Esto lo hacemos para porder manejar de mejor forma los datos que responde el servidor. hoy son pocos, pero hay veces que pueden ser muchos.
            //El dataType es opcional en AJAX, aunque es una buena practica usarlo. Existen muchas posibilidades ademas de json... 
            // https://api.jquery.com/jquery.ajax/
            processData: false,
            data: formData, // enviamos el formData
            async: true,
            success: function(response) { //SI el ajax se ejecuta sin error ejecuta el success()
                if (response.success) {
                    $.notify("Se agrego correctamente", "success"); //notify es un plugin de js que envia notificaciones temporales.. es super sencillo. https://notifyjs.jpillora.com/ aca podes ver mas infromacion.
                    $('#grilla').DataTable().ajax.reload(); // recarga la grilla sin necesida de recargar la pagina. 
                    $("#modalEdtPro").modal('hide');
                } else {
                    $.notify("Ocurrio un error.", "danger");
                    $("#modalEdtPro").modal('hide');
                }
            },
            error: function(a, b, c) { //SI el ajax se ejecuta sin error ejecuta el error()
                $.notify("Error,", "danger");
                console.log(a);
                console.log(b);
            }
        });
    }

    function guardarNuevoProducto(nombre, precio, fk_idcategoria, fecha_subido) {
        var formData = new FormData();
        formData.append("do", "guardarNuevoProducto");
        formData.append("nombre", nombre);
        formData.append("precio", precio);
        formData.append("fk_idcategoria", fk_idcategoria);
        formData.append("fecha_subido", fecha_subido);

        $.ajax({
            type: 'POST',
            url: "funciones.php",
            contentType: false,
            dataType: 'json',
            processData: false,
            data: formData,
            async: true,
            beforeSend: function() {
                $('#btnAgregarNuevo').prop("disabled", true);
            },
            success: function(response) {
                if (response.success) {
                    $.notify("Se agrego correctamente", "success");
                    limpiarModal();
                    $('#grilla').DataTable().ajax.reload();
                    $("#modalProducto").modal('hide');
                    $('#btnAgregarNuevo').prop("disabled", false);
                } else {
                    $.notify("Ocurrio un error.", "danger");
                    $("#modalProducto").modal('hide');
                    $('#btnAgregarNuevo').prop("disabled", false);
                }
            },
            error: function(a, b, c) {
                $.notify("Error,", "danger");
                console.log(a);
                console.log(b);
            }
        });
    }

    function borrarProducto(id) {
        var formData = new FormData();
        formData.append("do", "borrarProducto");
        formData.append("id", id);
        $.ajax({
            type: 'POST',
            url: "funciones.php",
            contentType: false,
            dataType: 'json',
            processData: false,
            data: formData,
            async: true,
            success: function(response) {
                if (response.success) {
                    $.notify("Se eliminó correctamente", "success");
                    $('#grilla').DataTable().ajax.reload();
                    $("#modalDltPro").modal('hide');
                } else {
                    $.notify("Error, Esta categoria esta siendo usada por algun producto.", "danger");
                    $("#modalDltPro").modal('hide');
                }
            },
            error: function(a, b, c) {
                $.notify("Error,", "danger");
                console.log(a);
                console.log(b);
            }
        });
    }

    function limpiarModal() {
        $('#txtNombre').val("");
        $('#txtPrecio').val("");
        $('#txtCategoria').val("");
        $('#txtFecha').val("");
    }

    function editarProducto(btn) {
        let xHtmlMdlEdir = '<input type="hidden" name="txtIdPro" value="' + btn.getAttribute('data-id') + '" id="txtIdPro" class="form-control ">' +
            '<label for="txtNombre">Nombre: </label>' +
            '<input type="text" name="txtNombreEdit" id="txtNombreEdit" value="' + btn.getAttribute('data-nombre') + '" class="form-control ">' +

            '<label for="txtPrecio">Precio: </label>' +
            '<input type="text" name="txtPrecioEdit" id="txtPrecioEdit" value="' + btn.getAttribute('data-precio') + '" class="form-control ">' +

            '<label for="txtCategoria">Categoria: </label>' +
            '<input type="text" name="txtCategoriaEdit" id="txtCategoriaEdit" value="' + btn.getAttribute('data-fk_idcategoria') + '" class="form-control ">' +

            '<label for="txtFecha">Fecha Subido: </label>' +
            '<input type="text" name="txtFechaEdit" id="txtFechaEdit" value="' + btn.getAttribute('data-fecha_subido') + '" class="form-control ">';

        $('.html-mdlEdit').html('');
        $('.html-mdlEdit').html(xHtmlMdlEdir);
        $("#modalEdtPro").modal("show");
    }

    function deleteProducto(btn) {
        let xHtmlMdlDlt = '<input type="hidden" name="txtIdProDlt" value="' + btn.getAttribute('data-id') + '" id="txtIdProDlt" class="form-control ">' +
            ' Se eliminará El Nombre: ' + btn.getAttribute('data-nombre') + " ." +

            '<input type="hidden" name="txtIdProDlt" value="' + btn.getAttribute('data-id') + '" id="txtIdProDlt" class="form-control ">' +
            ' Se eliminará El Precio: ' + btn.getAttribute('data-precio') + " ." +

            '<input type="hidden" name="txtIdProDlt" value="' + btn.getAttribute('data-id') + '" id="txtIdProDlt" class="form-control ">' +
            ' Se eliminará la categoria: ' + btn.getAttribute('data-fk_idcategoria') + " ." +

            '<input type="hidden" name="txtIdProDlt" value="' + btn.getAttribute('data-id') + '" id="txtIdProDlt" class="form-control ">' +
            ' Se eliminará la Fecha: ' + btn.getAttribute('data-fecha_subido');

        $('.html-mdlDelete').html('');
        $('.html-mdlDelete').html(xHtmlMdlDlt);
        $("#modalDltPro").modal("show");
    }


    function cargarGrilla() { // esta funcion dispara un a peticion a funciones.php par apoder cargar la grilla con los datos que se retornen.
        $('#grilla').DataTable({
            responsive: true,
            processing: true,
            bFilter: true,
            bInfo: true,
            paging: false,
            pageLength: 25,
            order: [
                [0, "asc"]
            ],
            ajax: "funciones.php?do=cargarGrillaProductos",
            language: {
                "infoEmpty": "No existen registros",
                "search": "Buscar:"
            }
        });
    }
</script>

<?php include('footer.php');
