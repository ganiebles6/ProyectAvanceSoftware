<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="SiteMedia/Design/materialize/css/materialize.css"  media="screen,projection"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="SiteMedia/css/DefaultStyle.css"/>
        <link type="text/css" rel="stylesheet" href="SiteMedia/Design/sweetalert-master/dist/sweetalert2.css"/>
        <script type="text/javascript" src="SiteMedia/jQuery/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="SiteMedia/Design/materialize/js/materialize.js"></script>
        <script type="text/javascript" src="SiteMedia/Design/sweetalert-master/dist/sweetalert2.min.js"></script>
        <script type="text/javascript" src="SiteMedia/js/Filejs.js"></script>
        <title>Avances Software</title>
    </head>
    <body>

        <div class="card-panel teal darken-4">
            <div class="row">
                <div class="col s12">
                    <div class="row">
                        <div class="col s4 l5">
                            <h3 id="title"><span class="blue-text text-lighten-5">Gestión de Productos</span></h3>
                        </div>
                        <div class="col s4 l5">
                        </div>
                        <div class="col s2 l4">
                            <button class="waves-effect waves-light btn-large modal-trigger" href="#MyModal" id="new-product"><i class="material-icons left">add</i>Nuevo Producto</button>
                        </div>
                        <div class="col s2 l3">
                            <button class="waves-effect waves-light btn-large modal-trigger" href="#ModalBodega"><i class="material-icons left">add</i>Nueva Bodega</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="MyModal" class="modal">
            <div class="modal-content" id="container-form-product">

            </div>
        </div>

        <div id="ModalBodega" class="modal">
            <div class="modal-content">
                <h4>Registrar Bodega</h4>
                <br>
                <form  id="frm-bodega" action="?c=Bodega&a=SaveBodega" method="post" enctype="multipart/form-data">
                    <div class="input-field">
                        <input id="nombre" name="newbodega" type="text" class="validate" required="" aria-required="true">
                        <label for="newbodega" data-error="Complete el campo" data-success="right">Nombre de la bodega</label>
                    </div>

                    <div class="input-field">
                        <button class="btn waves-effect waves-light " type="submit" name="action" onclick="return confirm('Desea registrar la bodega?')">Guardar
                            <i class="material-icons left">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col s6 m6 l8">

                <div class="card-panel orange darken-4" id="title-products">
                    <h5>Productos en Stock</h5>
                </div>

                <div class="row" id="container-products">
                    <div class="col s6">
                        <form>
                            <div class="row">
                                <div class="input-field col s4">
                                    <select id="select-filtrer" onchange="GetWordFiltrer()">
                                        <option value="" selected>Elije una opción</option>
                                        <option value="numero">Número</option>
                                        <option value="producto">Nombre</option>
                                        <option value="bodega">Bodega</option>
                                        <option value="cantidad">Cantidad</option>
                                    </select>
                                    <label>Filtrar productos por:</label>
                                </div>
                                <div class="input-field col s7">
                                    <i class="material-icons prefix">search</i>
                                    <input id="search" type="text" onkeyup="MakeQueryProduct()"/>
                                    <label for="search">Buscar</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col s6">
                        <div class="row">
                            <div class="input-field col s2">

                            </div>
                            <div class="input-field col s5">
                                <button class="btn disabled waves-effect waves-light" id="edit-product">Editar
                                    <i class="material-icons left">edit</i>
                                </button>
                            </div>
                            <div class="input-field col s5">
                                <button class="btn disabled waves-effect waves-light red darken-4" id="delete-product">Eliminar
                                    <i class="material-icons left">delete</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="tabla-producto">
                    <thead class="teal darken-4 white-text">
                        <tr>
                            <th data-field="nroproducto">Producto ID</th>
                            <th data-field="nombreproducto">Nombre</th>
                            <th data-field="existencia">Existencia</th>
                            <th data-field="bodega">Bodega</th>
                            <th data-field="descripcion">Descripción</th>
                            <th data-field="estado">Estado</th>
                        </tr>
                    </thead>
                    <tbody id="container-data-product">
                        <?php
                        $this->ShowProducts();
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col s5 m5 l4">

                <div class="container-edit-product">
                    <?php
                    $this->ShowInformationTabs();
                    ?>
                </div>
            </div>
        </div>

        <footer class="page-footer teal darken-3">

            <div class="row" id="container-footer">
                <div class="col l6 s12">
                    <h5 class="white-text">Información general</h5>
                    <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Links</h5>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-copyright deep-orange black-text">
                <div class="container">
                    © 2014 Copyright Text
                    <a class="black-text text-lighten-4 right" href="#!">More Links</a>
                </div>
            </div>
        </footer>
    </body>
</html>
