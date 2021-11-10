<?php

include_once "controladores/ControladorContacto.php";
include_once "controladores/ControladorCliente.php";
include_once "controladores/ControladorRuta.php";
include_once "controladores/ControladorAuth.php";

include_once "modelos/ModeloCliente.php";
include_once "modelos/ModeloContacto.php";


$ruta = new ControladorRuta();
$ruta->index();

