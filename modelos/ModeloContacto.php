<?php
require_once "conexion.php";
class ModeloContacto
{
    static function index($tabla)
    {
 
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
     
        $stmt->execute();
      
     return $stmt->fetchAll(PDO::FETCH_CLASS);

       

    }

      //crear un nuevo contacto
      static function create($tabla,$datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla ( nombre, apellido, email, telefono, id_creador, created_at, update_at)
         VALUES (:nombre, :apellido, :email, :telefono, :id_creador, :created_at, :update_at)");

        $stmt->bindParam(":nombre",$datos['nombre'],PDO::PARAM_STR);
        $stmt->bindParam(":apellido",$datos['apellido'],PDO::PARAM_STR);
        $stmt->bindParam(":email",$datos['email'],PDO::PARAM_STR);
        $stmt->bindParam(":id_creador",$datos['id_creador'],PDO::PARAM_STR);
        $stmt->bindParam(":telefono",$datos['telefono'],PDO::PARAM_STR);
        $stmt->bindParam(":created_at",$datos['created_at'],PDO::PARAM_STR);
        $stmt->bindParam(":update_at",$datos['update_at'],PDO::PARAM_STR);

       if($stmt->execute()){
            return "OK";
       }else{

        print_r(Conexion::conectar()->errorInfo());
        $stmt = null;

       }
    
    }
//mostrar un solo contacto
    static function show($tabla, $id)
    {
 
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where id = :id");

        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
     
        $stmt->execute();
      
     return $stmt->fetchAll(PDO::FETCH_CLASS);

       $stmt = null;

    }

    //editar contacto
    static function update($tabla,$datos){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre=:nombre ,apellido=:apellido,email=:email,telefono=:telefono,update_at=:update_at WHERE id=:id");

        $stmt->bindParam(":nombre",$datos['nombre'],PDO::PARAM_STR);
        $stmt->bindParam(":apellido",$datos['apellido'],PDO::PARAM_STR);
        $stmt->bindParam(":email",$datos['email'],PDO::PARAM_STR);
        $stmt->bindParam(":id",$datos['id'],PDO::PARAM_INT);
        $stmt->bindParam(":telefono",$datos['telefono'],PDO::PARAM_STR);
        $stmt->bindParam(":update_at",$datos['update_at'],PDO::PARAM_STR);

       if($stmt->execute()){
            return "OK";
       }else{

        print_r(Conexion::conectar()->errorInfo());
        $stmt = null;

       }
    
    }


    //eliminar contacto
    static function delete($tabla,$id){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE id=:id");

        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
        

       if($stmt->execute()){
            return "OK";
       }else{

        print_r(Conexion::conectar()->errorInfo());
        $stmt = null;

       }
    
    }
}
