<?php
require_once "conexion.php";
 class ModeloUsuarios{
     /*=============================================
    REGISTRO DE USUARIO
    =============================================*/ 
     static public function mdlRegistroUsuarios($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,password,email,foto,modo,verificacion,emailEncriptado)
                                                                    VALUES (:nombre,:password,:email,:foto,:modo,:verificacion,:emailEncriptado)");
        $stmt ->bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);                                           
        $stmt ->bindParam(":password",$datos["password"],PDO::PARAM_STR);                                           
        $stmt ->bindParam(":email",$datos["email"],PDO::PARAM_STR);                                           
        $stmt ->bindParam(":foto",$datos["foto"],PDO::PARAM_STR);                                           
        $stmt ->bindParam(":modo",$datos["modo"],PDO::PARAM_STR);                                                                                    
        $stmt ->bindParam(":verificacion",$datos["verificacion"],PDO::PARAM_INT);     
        $stmt ->bindParam(":emailEncriptado",$datos["emailEncriptado"],PDO::PARAM_STR);                                                                                    
        if($stmt->execute()){
            return "ok";
        }
        else{
            return "Error";
        }   
        $stmt->close();
        $stmt = null;                                 
     }
    /*=============================================
    MOSTRAR USUARIO
    =============================================*/ 
    static public function mdlMostrarUsuario($tabla,$item,$valor){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item");
        $stmt ->bindParam(":".$item,$valor,PDO::PARAM_STR);       
        $stmt ->execute();
        return $stmt -> fetch();
        $stmt->close();
        $stmt = null;                                  
    }
    /*=============================================
    ACTUALIZAR USUARIO
    =============================================*/ 
    static public function mdlActualizarUsuario($tabla,$id,$item,$valor){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item=:$item WHERE id= :id");
        $stmt ->bindParam(":".$item,$valor,PDO::PARAM_STR);       
        $stmt ->bindParam(":id",$id,PDO::PARAM_STR);     
        if($stmt ->execute()){
            return "ok";
        }
        else{
            return "error";
        }   
        $stmt->close();
        $stmt = null;                                  
    }
    /*=======================================
    ACTUALIZAR PERFIL
    =======================================*/
    static public function mdlActualizarPerfil($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre,password = :password,email = :email,foto = :foto WHERE id = :id");
        $stmt ->bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);                                           
        $stmt ->bindParam(":password",$datos["password"],PDO::PARAM_STR);                                           
        $stmt ->bindParam(":email",$datos["email"],PDO::PARAM_STR);                                           
        $stmt ->bindParam(":foto",$datos["foto"],PDO::PARAM_STR);                                                                                                                          
        $stmt ->bindParam(":id",$datos["id"],PDO::PARAM_INT);                                                                                                                          
        if($stmt->execute()){
            return "ok";
        }
        else{
            return "Error";
        }   
        $stmt->close();
        $stmt = null;
    }
    /*=============================================
    MOSTRAR USUARIO
    =============================================*/ 
    static public function mdlMostrarCompras($tabla,$item,$valor){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item");
        $stmt ->bindParam(":".$item,$valor,PDO::PARAM_STR);       
        $stmt ->execute();
        return $stmt -> fetchAll();
        $stmt->close();
        $stmt = null;                                  
    }
 }
 