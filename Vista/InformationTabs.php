
<div class="card-panel orange darken-4" id="title-products">
    <h5>Bodegas registradas</h5>
</div>
<div class="input-field col s4">
    <select id="select-filtrer">
        <option value="" selected>Elije una opción</option>
        <option value="numero">Número</option>
        <option value="producto">Nombre</option>
    </select>
    <label>Filtrar productos por:</label>
</div>
<div class="input-field col s7">
    <i class="material-icons prefix">search</i>
    <input id="search" type="text"/>
    <label for="search">Buscar</label>
</div>
<table class="highlight">
    <thead>
        <tr>
            <th data-field="idbodeda">Bodega ID</th>
            <th data-field="nombrebodega">Nombre</th>
            <th data-field="accion">Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $this->QueryAllDataBodega();
        ?>
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function () {
        $('.modal').modal();
        $('select').material_select();
        $('.tooltipped').tooltip();
    });
</script> 


<div id="modal-delete-bodega" class="contenido-modal-delete-bodega">
    <div class="contenido-modal">
        <header class="modalheader red darken-4"> 
            <span onclick="document.getElementById('modal-delete-bodega').style.display = 'none'" class="buton-close-modal displayclosemodal">&times;</span>
            <h4>Atención</h4>
        </header>
        <div class="modal-content-my">
            <p id="aviso-delete"></p>
        </div>
        <footer class="modalfooter red darken-4">
            <button class="waves-effect waves-light btn red darken-2" id="butonmodalfooter" onclick="ConfirmDeleteBodega()"><i class="tiny material-icons right">delete</i>Aceptar</button>
        </footer>
    </div>
</div>