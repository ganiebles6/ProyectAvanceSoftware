<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controlador
 *
 * @author ganie
 */
require 'Modelo/ProductModel.php';

class Controlador {

    //put your code here
    private $model1;

    function __construct() {

        $this->model1 = new ProductModel();
    }

    public function IndexDefault() {

        //$data = array();
        require_once 'Vista/indexView.php';
    }

    public function ShowProducts() {
        //$this->model1 = new ProductModel();

        $this->model1->MostrarProductos();
    }

    public function ShowBodegas() {
        //require_once 'Modelo/ProductModel.php';
        $this->model1->MostrarBodegas();
    }

    public function SaveProduct() {
        //require_once 'Modelo/ProductModel.php';
        $model = new ProductModel();

        $model->nombreProducto = $_REQUEST['nombre'];
        $model->cantidadProducto = $_REQUEST['cantidad'];
        $model->bodega = $_REQUEST['bodega'];
        $model->descripcion = $_REQUEST['descripcion'];

        isset($_REQUEST['id']) ? $this->model1->UpdateProduct($model) : $this->model1->InsertProduct($model);
    }

    public function SaveBodega() {

        $model = new ProductModel();
        $model->newBodega = $_REQUEST['newbodega'];
        $this->model1->InsertarBodega($model);
    }

    public function DeleteProduct() {
        $model = new ProductModel();

        $model->idProduct = $_REQUEST['id'];

        $this->model1->BorrarProducto($model);
    }

    public function ShowFormProduct() {


        if (isset($_REQUEST['id'])) {
            $product = new ProductModel();
            $numproducto = $_REQUEST['id'];
            $sql = "select producto.id_producto, producto.nombre_producto, producto.existencia, bodega.nombre_bodega,
                producto.descripcion, producto.estado from bodega
                inner join producto on producto.nro_bodega = bodega.id_bodega
                where producto.id_producto = $numproducto";
            $product = $this->model1->Consulta($sql);
        }

        include 'Vista/FormProduct.php';
    }

    public function ShowProductFiltrer() {
        $objectModel = new ProductModel();
        $objectModel->wordKey = $_REQUEST['d'];
        $objectModel->typeFiltrer = $_REQUEST['tf'];
        $this->model1->ShowProductFiltred($objectModel);
    }

    public function ShowInformationTabs() {
        include_once 'Vista/InformationTabs.php';
    }

    private function QueryAllDataBodega() {
        $this->model1->ShowDataBodega();
    }

}

//6 campos de la base de datos, el último es default








