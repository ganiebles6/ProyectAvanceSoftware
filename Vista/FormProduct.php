<div class="card-panel orange darken-4" id="title-products">
    <h5>
        <?php echo isset($product[1]) ? "Editar producto" : "Registrar Producto"; ?>
    </h5>
</div>

<form id="frm-producto" action="index.php?c=Producto&a=SaveProduct<?php
if (isset($_REQUEST['id'])) {
    echo "&id=" . $_REQUEST['id'];
}
?>" method="post" enctype="multipart/form-data">
    <div class="input-field">
        <input id="nombre" value="<?php echo isset($product[1]) ? $product[1] : ""; ?>" name="nombre" type="text" class="validate" required="" aria-required="true">
        <label for="nombre" class="<?php echo isset($product[1]) ? "active" : ""; ?>" data-error="wrong" data-success="right">Nombre del producto</label>
    </div>
    <div class="input-field">
        <input id="cantidad" name="cantidad" value="<?php echo isset($product[2]) ? $product[2] : ""; ?>" type="number" class="validate" required="" aria-required="true">
        <label for="cantidad" class="<?php echo isset($product[2]) ? "active" : ""; ?>">Cantidad</label>
    </div>
    <div class="input-field">
        <select id="bodega" name="bodega" class="validate" required="" aria-required="true">
            <?php
            if (isset($product[3])) {
                echo "<option value='$product[3]' selected>$product[3]</option>";
                echo $this->ShowBodegas();
            } else {
                echo "<option value='' disabled selected>Seleccione una opción</option>";
                echo $this->ShowBodegas();
            }
            ?>
        </select>
        <label>Bodega</label>
    </div>

    <div class="input-field">
        <textarea name="descripcion" class="materialize-textarea"><?php echo isset($product[4]) ? $product[4] : ""; ?></textarea>
        <label for="descripcion" class="<?php echo isset($product[4]) ? "active" : ""; ?>">Descripción</label>
    </div>

    <div class="input-field" id="action-submit">
        <button class="btn waves-effect waves-light " type="submit" name="action"><?php echo isset($product) ? "Actualizar" : "Guardar"; ?>
            <i class="material-icons left">send</i>
        </button>
    </div>

</form>
<script type="text/javascript">
    $(document).ready(function () {


        $('select').material_select();

    });
</script>
