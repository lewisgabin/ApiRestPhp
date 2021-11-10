<?php
class ContoladorContacto
{
    //listar todos los contactatos 
    public function index()
    {
        //validar credenciales del cliente
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {

            if (ControladorAuth::auntetificar($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {

                $contactos = ModeloContacto::index('contactos');
                //si la variable contacto tiene registro
                if (!empty($contactos)) {
                    $json = array(
                        "status" => 200,
                        "total_registro" => count($contactos),
                        "detalle" => $contactos
                    );

                    echo json_encode($json, true);
                    return;
                } else {
                    $json = array(
                        "status" => 200,
                        "total_registro" => 0,
                        "detalle" => "No hay contactos registrados"
                    );

                    echo json_encode($json, true);
                    return;
                }
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "Token invalido"
                );
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No esta autorizado para recibir los datos"
            );
        }
        echo json_encode($json, true);
        return;
    }

    //crear el contacto
    public function create($datos)
    {

        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {

            if (ControladorAuth::auntetificar($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {

                //validar nombre
                if (isset($datos['nombre']) && !preg_match('/^[.\\a-zA-ZáéíóúÁÉÜÍÓÚÑñ ]+$/', $datos['nombre'])) {
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
                //validar telefono
                if (isset($datos['telefono']) &&  !preg_match('/^[[:digit:][-]+$/', $datos['telefono'])) {
                    $json = array(
                        "status" => 404,
                        "detalle" => "Error en el campo telefono es requerido, solo se permiten numeros y guion"
                    );
                    echo json_encode($json, true);
                    return;
                }

                //validar que el email sea unico   
                $contactoEmail = ModeloContacto::index('contactos');

                foreach ($contactoEmail as $key => $value) {

                    if ($value->email == $datos['email']) {

                        $json = array(
                            "status" => 404,
                            "detalle" => "El email ya esta registrado, intente con otro email"
                        );
                        echo json_encode($json, true);
                        return;
                    }
                }

                $datos = array(
                    "nombre" => $datos['nombre'],
                    "apellido" => $datos['apellido'],
                    "email" => $datos['email'],
                    "telefono" => $datos['telefono'],
                    "id_creador" => $_SERVER['PHP_AUTH_USER'],
                    "created_at" => date("Y-m-d h:i:s"),
                    "update_at" => date("Y-m-d h:i:s")

                );

                $create = ModeloContacto::create('contactos', $datos);
                if ($create == "OK") {
                    $json = array(
                        "status" => 404,
                        "detalle" => "Registro exitoso, Contacto guardado",
                    );

                    echo json_encode($json, true);
                    return;
                }
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "Token invalido"
                );
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No esta autorizado para recibir los datos"
            );
        }
        echo json_encode($json, true);
        return;
    }
    //ver un solo contacto
    public function show($id)
    {
        //validar credenciales del cliente
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {

            if (ControladorAuth::auntetificar($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {

                $contacto = ModeloContacto::show('contactos', $id);
                //si la variable contacto tiene registro
                if (!empty($contacto)) {
                    $json = array(
                        "status" => 200,
                        "detalle" => $contacto
                    );

                    echo json_encode($json, true);
                    return;
                } else {
                    $json = array(
                        "status" => 200,
                        "total_registro" => 0,
                        "detalle" => "No hay contactos registrados"
                    );

                    echo json_encode($json, true);
                    return;
                }
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "Token invalido"
                );
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No esta autorizado para recibir los datos"
            );
        }
        echo json_encode($json, true);
        return;
    }

    //editar el contacto
    public function update($id, $datos)
    {
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {

            if (ControladorAuth::auntetificar($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {

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
                //validar telefono
                if (isset($datos['telefono']) &&  !preg_match('/^[[:digit:][-]+$/', $datos['telefono'])) {
                    $json = array(
                        "status" => 404,
                        "detalle" => "Error en el campo telefono es requerido, solo se permiten numeros y guion"
                    );
                    echo json_encode($json, true);
                    return;
                }

                //validar el creador 
                $contacto = ModeloContacto::index('contactos');
                if (empty($contacto)) {

                    $json = array(
                        "status" => 404,
                        "detalle" => "No existe este contacto",
                    );
                    echo json_encode($json, true);
                    return;
                } else {
                    foreach ($contacto as $key => $value) {


                        if ($value->id_creador == $_SERVER['PHP_AUTH_USER']) {

                            $datos = array(
                                "id" => $id,
                                "nombre" => $datos['nombre'],
                                "apellido" => $datos['apellido'],
                                "email" => $datos['email'],
                                "telefono" => $datos['telefono'],
                                "update_at" => date("Y-m-d h:i:s")

                            );

                            $update = ModeloContacto::update('contactos', $datos);
                            if ($update == "OK") {
                                $json = array(
                                    "status" => 404,
                                    "detalle" => "Registro exitoso, Contacto ah sido actualizado",
                                );
                                echo json_encode($json, true);
                                return;
                            }
                        } else {
                            $json = array(
                                "status" => 404,
                                "detalle" => "El Usuario no es el creador de este contacto, no tiene el accesoa editar"
                            );
                            echo json_encode($json, true);
                            return;
                        }
                    }
                }
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "Token invalido"
                );
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No esta autorizado para recibir los datos"
            );
        }
        echo json_encode($json, true);
        return;
    }


    //borrar el contacto
    public function delete($id)
    {
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {

            if (ControladorAuth::auntetificar($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {

                //validar el creador 
                $contacto = ModeloContacto::index('contactos');
                //si no hay registro para eliminar
                if (empty($contacto)) {
                    $json = array(
                        "status" => 404,
                        "detalle" => "No existe este contacto",
                    );
                    echo json_encode($json, true);
                    return;
                } else {
                    foreach ($contacto as $key => $value) {


                        if ($value->id_creador == $_SERVER['PHP_AUTH_USER']) {

                            $delete = ModeloContacto::delete('contactos', $id);

                            if ($delete == "OK") {
                                $json = array(
                                    "status" => 404,
                                    "detalle" => "Registro elimindo, Contacto ah sido eliminado",
                                );
                                echo json_encode($json, true);
                                return;
                            }
                        } else {
                            $json = array(
                                "status" => 404,
                                "detalle" => "El Usuario no es el creador de este contacto, no tiene el accesoa a eliminarlo"
                            );
                        }
                    }
                }
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "Token invalido"
                );
                echo json_encode($json, true);
                return;
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No esta autorizado para eliminar los datos"
            );
            echo json_encode($json, true);
            return;
        }
    }
}
