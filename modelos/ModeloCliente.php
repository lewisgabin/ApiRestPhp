<?php
require_once "conexion.php";
class ModeloCliente
{
   //mostar todos los clientes
    static function index($tabla)
    {

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);

    }

    //crear un nuevo cliente
    static function create($tabla,$datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, apellido, email, id_cliente, llave_secreta, created_at, update_at)
         VALUES (:nombre, :apellido, :email, :id_cliente, :llave_secreta, :created_at, :update_at)");

        $stmt->bindParam(":nombre",$datos['nombre'],PDO::PARAM_STR);
        $stmt->bindParam(":apellido",$datos['apellido'],PDO::PARAM_STR);
        $stmt->bindParam(":email",$datos['email'],PDO::PARAM_STR);
        $stmt->bindParam(":id_cliente",$datos['id_cliente'],PDO::PARAM_STR);
        $stmt->bindParam(":llave_secreta",$datos['llave_secreta'],PDO::PARAM_STR);
        $stmt->bindParam(":created_at",$datos['created_at'],PDO::PARAM_STR);
        $stmt->bindParam(":update_at",$datos['update_at'],PDO::PARAM_STR);

      
       if($stmt->execute()){
            return "OK";
       }else{

        print_r(Conexion::conectar()->errorInfo());
        $stmt = null;

       }
    
    }
}
