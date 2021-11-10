<?php

class ControladorAuth
{
    // autentificar el cliente
    public static function auntetificar($idCliente, $clavePrivada)
    {
        $clientes = ModeloCliente::index('clientes');
        $valor = false;

        foreach ($clientes as $key => $valueCliente) {

            if ("Basic " . base64_encode(trim($idCliente) . ":" . trim($clavePrivada)) == "Basic " . base64_encode(trim($valueCliente->id_cliente) . ":" . trim($valueCliente->llave_secreta))) {
                $valor = true;
            }
        }

        return $valor;
    }
}
