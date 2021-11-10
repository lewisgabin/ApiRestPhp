<?php
class ContoladorCliente
{
    // Registrar cliente
    public function create($datos)
    {
        //validar cliente 
        //validar nombre
        if (isset($datos['nombre']) && !preg_match('/^[a-zA-ZáéíóúÁÉÜÍÓÚÑñ ]+$/', $datos['nombre'])) {
            $json = array(
                "status" => 404,
                "detalle" => "Error en el campo nombre es requerido, solo se permiten letras."
            );
            echo json_encode($json, true);
            return;
        }
        //validar apellido
        if (isset($datos['apellido']) && !preg_match('/^[a-zA-ZáéíóúÁÉÜÍÓÚÑñ ]+$/', $datos['apellido'])) {
            $json = array(
                "status" => 404,
                "detalle" => "Error en el campo apellido es requerido, solo se permiten letras."
            );
            echo json_encode($json, true);
            return;
        }
        //validar email
        if (isset($datos['email']) &&  !preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $datos['email'])) {
            $json = array(
                "status" => 404,
                "detalle" => "Error en el campo email es requerido, solo se permiten correos"
            );
            echo json_encode($json, true);
            return;
        }

        //validar que el email sea unico   
        $clientesEmail = ModeloCliente::index('clientes');

        foreach ($clientesEmail as $key => $value) {
          
            if ($value->email == $datos['email']) {

                $json = array(
                    "status" => 404,
                    "detalle" => "El email ya esta registrado, intente con otro email"
                );
                echo json_encode($json, true);
                return;
            }
        }

        //generar la credenciales de clientes
        $idCliente = str_replace(array("$", "/"), "c", crypt($datos['nombre'] . $datos['apellido'] . $datos['email'], '$2a$07$y3745jJD7ld93jdgfg5fs$'));
        $llaveSecreta = str_replace(array("$", "/"), "l", crypt($datos['email'] . $datos['apellido'] . $datos['nombre'], '$2a$07$y3745jJD7ld93jdgfg5fs$'));

        //Llevar datos al modelo
        $datos = array(
            "nombre" => $datos['nombre'],
            "apellido" => $datos['apellido'],
            "email" => $datos['email'],
            "id_cliente" => $idCliente,
            "llave_secreta"  =>   $llaveSecreta,
            "created_at" => date("Y-m-d h:i:s"),
            "update_at" => date("Y-m-d h:i:s"),
        );

        $create = ModeloCliente::create('clientes', $datos);

        if ($create == "OK") {
            $json = array(
                "status" => 404,
                "detalle" => "Registro exitoso, tome sus credenciales y guardelas",
                "crendenciales" => array("id_cliente" => $idCliente, "llave_secreta" => $llaveSecreta)
            );

            echo json_encode($json, true);
            return;
        }
    }
}
