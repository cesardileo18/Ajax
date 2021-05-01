<?php
include_once("config.php");
include_once("entidades/categoria.php");

?>
<?php include('header.php'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <style>
        .errInput {
            border: 1px solid red;
        }

        #modalProducto label {
            font-size: 12px;
            font-weight: bold;
        }
    </style>
    <div class="row my-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <i class="fa fa-table"></i> Categorias
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalProducto"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="panel-body p-2">
                    <table id="grilla" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Herramientas</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Categorias
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
    <div class="modal fade" id="modalEdtCat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Categorias
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
    <div class="modal fade" id="modalDltCat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-primary" id="btnDeleteCat">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <script>
        window.onload = function() {
            cargarGrilla();

            $('#btnDeleteCat').click(function() {
                //VALIDA SI EL FOMRULARIO TIENE ID, SI TIENE ID EJECUTA LA FUNCION borrarCateoria(id) -> dispara un ajax hacia funciones.php y elimina el id que le pasamos por parametro a la funcion.
                let id = $('#txtIdCatDlt').val();

                if (id == "" || id == null) {
                    $("#modalDltCat").modal("hide");
                }

                if (!(id == "" || id == null)) {
                    borrarCategoria(id);
                }
            });

            $('#btnActualizar').click(function() {
                //VALIDA SI EL FOMRULARIO TIENE ID Y NOMBRE, SI TIENE TODO EJECUTA LA FUNCION actualizarCategoria(id,nombre) -> dispara un ajax hacia funciones.php y actualiza la categoria por id.
                let nombre = $('#txtNombreEdit').val();
                let id = $('#txtIdCat').val();

                if (id == "" || id == null) {
                    $("#modalEdtCat").modal("hide");
                }

                if (nombre == "" || nombre == null) {
                    $('#txtNombreEdit').addClass('errInput');
                } else {
                    $('#txtNombreEdit').removeClass('errInput');
                }

                if (!(nombre == "" || nombre == null || id == "" || id == null)) {
                    actualizarCategoria(id, nombre);
                }
            });

            $('#btnAgregarNuevo').click(function() {
                //VALIDA SI EL FOMRULARIO TIENE  NOMBRE, SI TIENE TODO EJECUTA LA FUNCION guardarNuevoProducto(nombre) -> dispara un ajax hacia funciones.php y agrega la categoria.
                let nombre = $('#txtNombre').val();

                if (nombre == "" || nombre == null) {
                    $('#txtNombre').addClass('errInput');
                } else {
                    $('#txtNombre').removeClass('errInput');
                }

                if (!(nombre == "" || nombre == null)) {
                    guardarNuevoProducto(nombre);
                }
            });
            $('#txtIdCat').prop('disabled', true);
        }


        function actualizarCategoria(id, nombre) {
            /*
            
            El formData crea un arreglo de datos que luego enviamos en el ajax para realizar la funcion requerida.

            Funciona como un array asociativo.

            formData.append("nombre clave dentro del formdata", "valor a almacenar"); 

            Cada dato que agregamos al form data es deforma opcional... envias los datos que necesitas.
            
            */
            var formData = new FormData(); // creamos form data
            formData.append("do", "actualizarCategoria");
            formData.append("id", id);
            formData.append("nombre", nombre);

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
                        $("#modalEdtCat").modal('hide');
                    } else {
                        $.notify("Ocurrio un error.", "danger");
                        $("#modalEdtCat").modal('hide');
                    }
                },
                error: function(a, b, c) { //SI el ajax se ejecuta sin error ejecuta el error()
                    $.notify("Error,", "danger");
                    console.log(a);
                    console.log(b);
                }
            });
        }

        function guardarNuevoProducto(nombre) {
            var formData = new FormData();
            formData.append("do", "guardarNuevaCategoria");
            formData.append("nombre", nombre);
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

        function borrarCategoria(id) {
            var formData = new FormData();
            formData.append("do", "borrarCategoria");
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
                        $("#modalDltCat").modal('hide');
                    } else {
                        $.notify("Error, Esta categoria esta siendo usada por algun producto.", "danger");
                        $("#modalDltCat").modal('hide');
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
        }

        function editarCategoria(btn) {
            let xHtmlMdlEdir = '<input type="hidden" name="txtIdCat" value="' + btn.getAttribute('data-id') + '" id="txtIdCat" class="form-control ">' +
                '<label for="txtNombre">Nombre: </label>' +
                '<input type="text" name="txtNombreEdit" id="txtNombreEdit" value="' + btn.getAttribute('data-nombre') + '" class="form-control ">';
            $('.html-mdlEdit').html('');
            $('.html-mdlEdit').html(xHtmlMdlEdir);
            $("#modalEdtCat").modal("show");
        }

        function deleteCategoria(btn) {
            let xHtmlMdlDlt = '<input type="hidden" name="txtIdCatDlt" value="' + btn.getAttribute('data-id') + '" id="txtIdCatDlt" class="form-control ">' +
                'Se eliminará la categoria: ' + btn.getAttribute('data-nombre');
            $('.html-mdlDelete').html('');
            $('.html-mdlDelete').html(xHtmlMdlDlt);
            $("#modalDltCat").modal("show");
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
                ajax: "funciones.php?do=cargarGrillaCategorias",
                language: {
                    "infoEmpty": "No existen registros",
                    "search": "Buscar:"
                }
            });
        }
    </script>

    <?php include('footer.php');
