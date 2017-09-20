/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var numProducto = 0, xmlhttp = null, search, wordKeyfiltrer = "";

$(document).ready(function () {

    $('.modal').modal();
    $('select').material_select();
    $('ul.tabs').tabs();

});

window.onload = function () {
    search = document.getElementById("search");
    search.setAttribute("disabled", "true");

    if (window.XMLHttpRequest) {

        xmlhttp = new XMLHttpRequest();
    } else {

        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
};


function EnableInputs(check) {

    var temp = check.id;
    var num = temp.charAt(5);
    numProducto = $("#" + temp).val();
    var cont = 0;

    if ($("#" + temp).is(":checked")) {
        $(".row" + num).css("background-color", "#cfd8dc");
    } else {
        $(".row" + num).css("background-color", "white");
    }
    $("input[type=checkbox]:checked").each(
            function () {
                cont++;
            }
    );

    if (cont === 1) {

        $("#edit-product").removeClass("btn disabled waves-effect waves-light").addClass("btn waves-effect waves-light");
        $("#delete-product").removeClass("btn disabled waves-effect waves-light").addClass("btn waves-effect waves-light");
    } else if (cont > 1) {

        $("#delete-product").removeClass("btn disabled waves-effect waves-light").addClass("btn waves-effect waves-light");
        $("#edit-product").removeClass("btn waves-effect waves-light").addClass("btn disabled waves-effect waves-light");
    } else {
        $("#delete-product").removeClass("btn waves-effect waves-light").addClass("btn disabled waves-effect waves-light");
        $("#edit-product").removeClass("btn waves-effect waves-light").addClass("btn disabled waves-effect waves-light");
        ShowInformationTabs();
    }

}

$(document).ready(function () {
    $("#delete-product").click(function () {

        swal({title: "¿Estás seguro?",
            text: "El producto seleccionado será eliminado del stock!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Borrar!",
            cancelButtonText: "Cancelar"

        }).then(function () {
            $.get("index.php", {c: "Producto", a: "DeleteProduct", id: numProducto})
                    .done(function () {
                        swal({
                            title: 'Borrado!',
                            type: "success",
                            text: 'El producto fué eliminado con éxito.',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            confirmButtonColor: '#3085d6',
                            timer: 2000
                        }).then(
                                function () {},
                                function (dismiss) {

                                    if (dismiss === 'timer') {
                                        window.location.href = "index.php";
                                    }
                                }
                        );
                    });
        });


    });

    $("#edit-product").on("click", function () {
        ShowFormEdit();
//xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


    });

    $("#new-product").on("click", function () {
        $("#container-form-product").load("index.php", {a: "ShowFormProduct", c: "Producto"});
    });

});

function GetWordFiltrer() {

    wordKeyfiltrer = document.getElementById("select-filtrer").value;

    if (wordKeyfiltrer !== "") {
        search.removeAttribute("disabled");
        switch (wordKeyfiltrer) {
            case "numero":
                search.setAttribute("type", "number");
                search.setAttribute("min", "0");
                break;

            case "cantidad":
                search.setAttribute("type", "number");
                search.setAttribute("min", "0");
                break;

            default:
                search.setAttribute("type", "text");

                break;
        }

    } else {
        search.setAttribute("disabled", "true");
        ShowAllProducts();
    }
}

function MakeQueryProduct() {

    var valSearch = document.getElementById("search").value;
    if (valSearch.length === 0) {
        ShowAllProducts();
        $("#delete-product").removeClass("btn waves-effect waves-light").addClass("btn disabled waves-effect waves-light");
        $("#edit-product").removeClass("btn waves-effect waves-light").addClass("btn disabled waves-effect waves-light");
    } else {
        $("#delete-product").removeClass("btn waves-effect waves-light").addClass("btn disabled waves-effect waves-light");
        $("#edit-product").removeClass("btn waves-effect waves-light").addClass("btn disabled waves-effect waves-light");
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("container-data-product").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "index.php?a=ShowProductFiltrer&c=Producto&d=" + valSearch + "&tf=" + wordKeyfiltrer);
        xmlhttp.send();

    }
}

function ShowAllProducts() {
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("container-data-product").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "index.php?a=ShowProducts&c=Producto");
    xmlhttp.send();
}

function ShowFormEdit() {

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 1) {
            $(".container-edit-product").load("Vista/PreLoader.php");
        }
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            $(".container-edit-product").load("index.php", {a: "ShowFormProduct", c: "Producto", id: numProducto});
        }
    };

    xmlhttp.open("GET", "Vista/PreLoader.php");
    xmlhttp.send();

}

function ShowInformationTabs() {

    $(".container-edit-product").load("index.php", {a: "ShowInformationTabs", c: "Producto"});

}

function DeleteBodega() {
    document.getElementById("modal-delete-bodega").style.display = 'block';
    var valores = $("a").parents("tr").find("td")[0].innerHTML;
    console.log(valores);

}

//$(document).ready(function(){
//    $("button").click(function(){
//        $.get("Controlador/BodegaController.php", function(data, status){
//            alert("Data: " + data + "\nStatus: " + status);
//        });
//    });
//});


//$("button").click(function(){
//    $.post("demo_test_post.asp",
//    {
//        name: "Donald Duck",
//        city: "Duckburg"
//    },
//    function(data, status){
//        alert("Data: " + data + "\nStatus: " + status);
//    });
//});




