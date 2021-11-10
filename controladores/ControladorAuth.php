<?php

class ControladorAuth
{
    // autentificar el cliente
    public static function auntetificar($idCliente, $clavePrivada)
    {
        $clientes = ModeloCliente::index('clientes');
        $valor = false;
        foreach ($clientes as $key => $valueCliente) {

            if ("Basic " . base64_encode($idCliente . ":" . $clavePrivada) == "Basic " . base64_encode($valueCliente->id_cliente . ":" . $valueCliente->llave_secreta)) {
                $valor = true;
            }
        }

        return $valor;
    }
}
