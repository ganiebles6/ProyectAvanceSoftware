<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EntidadModelo
 *
 * @author ganie
 */
require 'Database/Conexion.php';

class ProductModel {

    //put your code here
    private $obtejoDB;
    private $conexion;
    public $nombreProducto, $cantidadProducto, $bodega, $descripcion, $newBodega, $idProduct, $typeFiltrer, $wordKey, $dinamicQuery;

    function __construct() {
        // put your code here
        $this->obtejoDB = new Conexion();
        $this->conexion = null;
    }

    function Consulta($sql) {

        try {

            $this->conexion = $this->obtejoDB->ReturnConnection();
            if (!$this->conexion->connect_errno > 0) {

                $resulset = mysqli_query($this->conexion, $sql);
                while ($resultados = mysqli_fetch_row($resulset)) {
                    return $resultados;
                }
            } else {
                return FALSE;
            }
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        $resulset->close();
        $this->conexion->close();
    }

    function InsertProduct(ProductModel $dataProduct) {

        try {

            $id_bodega = $this->Consulta("select id_bodega from bodega where nombre_bodega = '$dataProduct->bodega' limit 1");
            $nroBodega = 0;

            foreach ($id_bodega as $value) {
                $nroBodega = $value[0];
            }

            $this->conexion = $this->obtejoDB->ReturnConnection();

            $query = "INSERT INTO producto VALUES (NULL, '$dataProduct->nombreProducto', $dataProduct->cantidadProducto, $nroBodega,"
                    . "'$dataProduct->descripcion', 'ACTIVO')";
            $this->conexion->query($query);
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
        $this->conexion->close();
        header('Location: index.php');
    }

    function MostrarProductos() {

        try {

            $this->conexion = $this->obtejoDB->ReturnConnection();
            if (!$this->conexion->connect_errno > 0) {
                $query;

                if ($this->dinamicQuery !== null) {
                    $query = $this->dinamicQuery;
                } else {

                    $query = "select producto.id_producto, producto.nombre_producto, producto.existencia, bodega.nombre_bodega,
                producto.descripcion, producto.estado from bodega
                inner join producto on producto.nro_bodega = bodega.id_bodega;";
                }

                $resulset = mysqli_query($this->conexion, $query);
                $cont = 0;
                $numrows = mysqli_num_rows($resulset);

                if ($numrows > 0) {
                    while ($resultados = mysqli_fetch_row($resulset)) {
                        $cont++;
                        echo "<tr class='row$cont'>";
                        echo "<td>";
                        echo "<form action='#'>";
                        echo "<p>";
                        echo "<input onclick=EnableInputs(this) value = '$resultados[0]' type='checkbox' class='filled-in' id='check$cont'/>";
                        echo "<label for='check$cont'>$resultados[0]</label>";
                        echo "</p>";
                        echo "</form>";
                        echo "</td>";
                        echo "<td>$resultados[1]</td>";
                        echo "<td>$resultados[2]</td>";
                        echo "<td>$resultados[3]</td>";
                        echo "<td>$resultados[4]</td>";
                        echo "<td>$resultados[5]</td>";
                        echo "</tr>";
                    }
                } else {
                    if (!isset($this->dinamicQuery)) {
                        echo "<tr>";
                        echo "<td>No hay productos registrados</td>";
                        echo "</td>";
                        $sql = "ALTER TABLE producto AUTO_INCREMENT = 0";
                        $this->RestartAutoincrement($sql);
                    } else {
                        echo "<tr>";
                        echo "<td>No hay resultados en la busqueda</td>";
                        echo "</td>";
                    }
                }
            }
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        $resulset->close();
        $this->conexion->close();
    }

    function MostrarBodegas() {

        try {

            $this->conexion = $this->obtejoDB->ReturnConnection();
            if (!$this->conexion->connect_errno > 0) {
                $sql = "select nombre_bodega from bodega;";
                $resulset = mysqli_query($this->conexion, $sql);
                while ($resultados = mysqli_fetch_row($resulset)) {
                    echo "<option>" . $resultados[0] . "</option>";
                }
            } else {
                return FALSE;
            }
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        $resulset->close();
        $this->conexion->close();
    }

    function InsertarBodega(ProductModel $nombreBodega) {

        try {

            $this->conexion = $this->obtejoDB->ReturnConnection();
            $sql = "INSERT INTO bodega VALUES(NULL, '$nombreBodega->newBodega')";
            mysqli_query($this->conexion, $sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        $this->conexion->close();
        header("Location:index.php");
    }

    function BorrarProducto(ProductModel $id) {

        try {
            $this->conexion = $this->obtejoDB->ReturnConnection();
            $enableDelete = $this->DisableCheckForeign();

            if ($enableDelete === TRUE) {
                $query = "DELETE FROM producto WHERE id_producto = $id->idProduct";
                mysqli_query($this->conexion, $query);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        $this->EnableCheckForeign();

        $this->conexion->close();

        header('Location: index.php');
    }

    function DisableCheckForeign() {

        try {
            $this->conexion = $this->obtejoDB->ReturnConnection();
            $sql = "set foreign_key_checks = 0";
            mysqli_query($this->conexion, $sql);
            $affect = mysqli_affected_rows($this->conexion);
            if ($affect === 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    private function EnableCheckForeign() {

        try {
            $this->conexion = $this->obtejoDB->ReturnConnection();
            $sql = "set foreign_key_checks = 1";
            mysqli_query($this->conexion, $sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    private function RestartAutoincrement($sql) {
        try {
            $this->conexion = $this->obtejoDB->ReturnConnection();
            mysqli_query($this->conexion, $sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function UpdateProduct($dataEdit) {

        try {

            $this->conexion = $this->obtejoDB->ReturnConnection();

            if (!$this->conexion->connect_errno) {
                $idProducto = $_REQUEST['id'];
                $nombreBodega = $dataEdit->bodega;
                $idBodega = $this->Consulta("SELECT id_bodega FROM bodega WHERE nombre_bodega = '$nombreBodega' LIMIT 1");

                foreach ($idBodega as $value) {
                    $nroBodega = $value[0];
                }
            }
            $sql = "UPDATE producto SET "
                    . "nombre_producto = '$dataEdit->nombreProducto',"
                    . "existencia = $dataEdit->cantidadProducto,"
                    . "nro_bodega = $nroBodega,"
                    . "descripcion = '$dataEdit->descripcion'"
                    . "WHERE id_producto = $idProducto;";
            mysqli_query($this->conexion, $sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        //$this->conexion->close();
        header('Location: index.php');
    }

    public function ShowProductFiltred($datafiltrer) {

        switch ($datafiltrer->typeFiltrer) {
            case "numero":

                $this->dinamicQuery = "SELECT producto.id_producto, producto.nombre_producto, producto.existencia, bodega.nombre_bodega,
                producto.descripcion, producto.estado FROM bodega
                INNER JOIN producto ON producto.nro_bodega = bodega.id_bodega
                WHERE producto.id_producto = $datafiltrer->wordKey;";
                $this->MostrarProductos();
                break;
            case "producto":

                $this->dinamicQuery = "SELECT producto.id_producto, producto.nombre_producto, producto.existencia, bodega.nombre_bodega,
                producto.descripcion, producto.estado FROM bodega
                INNER JOIN producto ON producto.nro_bodega = bodega.id_bodega
                WHERE producto.nombre_producto LIKE '$datafiltrer->wordKey%';";
                $this->MostrarProductos();
                break;

            case "cantidad":
                $this->dinamicQuery = "SELECT producto.id_producto, producto.nombre_producto, producto.existencia, bodega.nombre_bodega,
                producto.descripcion, producto.estado FROM bodega
                INNER JOIN producto ON producto.nro_bodega = bodega.id_bodega
                WHERE producto.existencia = $datafiltrer->wordKey;";
                $this->MostrarProductos();
                break;

            case "bodega":

                $id_bodega = $this->Consulta("SELECT id_bodega FROM bodega WHERE nombre_bodega LIKE '$datafiltrer->wordKey%' LIMIT 1;");
                $nroBodega = 0;
                if (isset($id_bodega)) {

                    foreach ($id_bodega as $value) {
                        $nroBodega = $value[0];
                    }
                }

                $this->dinamicQuery = "SELECT producto.id_producto, producto.nombre_producto, producto.existencia, bodega.nombre_bodega,
                producto.descripcion, producto.estado FROM bodega
                INNER JOIN producto ON producto.nro_bodega = bodega.id_bodega
                WHERE producto.nro_bodega = $nroBodega;";
                $this->MostrarProductos();
                break;
        }
        //echo "<td>$datafiltrer->wordKey</td>";
    }

    public function ShowDataBodega() {

        $this->conexion = $this->obtejoDB->ReturnConnection();
        $query = "SELECT * FROM bodega";
        $registros = mysqli_query($this->conexion, $query);
        $numRegistros = mysqli_num_rows($registros);
        if ($numRegistros == 0) {
            echo 'No hay usuarios';
        } else {
            while ($resultados = mysqli_fetch_row($registros)) {

                echo "<tr class='row'>";
                echo "<td>$resultados[0]</td>";
                echo "<td>$resultados[1]</td>";
                echo "<td>";
                echo "<a href='#' class='tooltipped' data-position='top' data-tooltip='Eliminar' onclick='DeleteBodega(this);' id='$resultados[0]'><i class='tiny material-icons red-text text-darken-4'>delete</i></a>"
                . "<a href='#' class='tooltipped' data-position='top' data-tooltip='Editar'><i class='tiny material-icons green-text text-darken-4'>edit</i></a>"
                . "<a href='#' class='tooltipped' data-position='top' data-tooltip='Agregar'><i class='tiny material-icons blue-text text-darken-4'>add</i></a>";
                echo "</td>";
                echo "</tr>";
            }
        }
    }

    public function DropBodega($value)
    {
        # code...
        echo "ya estamos listos $value";
    }

}
