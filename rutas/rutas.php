<?php
$arrayRutas = explode('/', $_SERVER['REQUEST_URI']);

//echo "<pre>"; print_r(array_filter($arrayRutas)[1]);      echo "</pre>";
//cuando no se hace ninguna peticion a la api
if (count(array_filter($arrayRutas)) == 0) {

    $json = array(
        "detalle" => "no encontrdado"
    );

    echo json_encode($json, true);
    return;
} else {
    // si la uri tiene un solo valor
    if (count(array_filter($arrayRutas)) == 1) {
        // cuando se hace una peticion desde contacto
        if (array_filter($arrayRutas)[1] == "contacto") {
            //peticion de tipo GET
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                $contactos = new ContoladorContacto();
                $contactos->index();
            }
            //peticion de tipo POST
            else if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
                //capturando datos del contacto
                //valida que se envien las variables correcta
                if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['telefono'])) {
                    $datos = array(
                        "nombre" => $_POST['nombre'],
                        "apellido" => $_POST['apellido'],
                        "email" => $_POST['email'],
                        "telefono" => $_POST['telefono'],
                    );

                    $crearContacto = new ContoladorContacto();
                    $crearContacto->create($datos);
                    return;
                } else {
                    $json = array(
                        "detalle" => "Debe de enviar los datos con la sigt Key",
                        "key" => array("nombre", "apellido", "telefono", "email")
                    );

                    echo json_encode($json, true);
                    return;
                }
            } else {
                $json = array(
                    "detalle" => "Ruta no encontrada",
                );

                echo json_encode($json, true);
                return;
            }
        }
        //cuando se hace una peticion desde registro 
        else if (array_filter($arrayRutas)[1] == "registro") {
            //peticion de tipo POST
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
                //capturando datos de clientes
                $datos = array(
                    "nombre" => $_POST['nombre'],
                    "apellido" => $_POST['apellido'],
                    "email" => $_POST['email'],
                );

                $cliente = new ContoladorCliente();
                $cliente->create($datos);
            }
        } else {
            $json = array(
                "detalle" => "Ruta no encontrada",
            );

            echo json_encode($json, true);
            return;
        }
    } else {
        //la uri tiena mas un un valor
        //cuando se hace un peticion desde un solo contacto
        if (array_filter($arrayRutas)[1] == "contacto" && is_numeric(array_filter($arrayRutas)[2])) {

            //peticion de tipo GET
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                $Contacto = new ContoladorContacto();
                $Contacto->show(array_filter($arrayRutas)[2]);
            }
            //peticion de tipo PUT
            else if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "PUT") {
                //capturar los datos 
                $datos = array();
                parse_str(file_get_contents('php://input'), $datos);
                if (isset($datos['nombre']) && isset($datos['apellido']) && isset($datos['email']) && isset($datos['telefono'])) {

                    $editarContacto = new ContoladorContacto();
                    $editarContacto->update(array_filter($arrayRutas)[2], $datos);
                } else {
                    $json = array(
                        "detalle" => "Debe de enviar los datos con la sigt Key",
                        "key" => array("nombre", "apellido", "telefono", "email")
                    );

                    echo json_encode($json, true);
                    return;
                }
            }
            //peticion de tipo DELETE
            else if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "DELETE") {
                $borrarContacto = new ContoladorContacto();
                $borrarContacto->delete(array_filter($arrayRutas)[2]);
            } else {
                $json = array(
                    "detalle" => "Ruta no encontrada",
                );

                echo json_encode($json, true);
                return;
            }
        } else {
            $json = array(
                "detalle" => "Ruta no encontrada",
            );

            echo json_encode($json, true);
            return;
        }
    }
}
