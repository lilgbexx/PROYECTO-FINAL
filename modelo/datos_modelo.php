<?php
class datos_modelo{


#Conexion BBDD
    private  $db; 


#Registro de BBDD
    private $datos; 

 

//FUNCION CONTRUCTOR
    public function __construct(){
        require_once("modelo/conectar.php");
        $this->db = conectar::conexion();
        $this->datos = array();
}


//FUNCION PARA OBTENER LOS DATOS    
    public function get_datos(){
        $sql="SELECT * FROM datos";
        $consulta = $this->db->query($sql);
        while($registro=$consulta->fetch_assoc()){
            $this->datos[]=$registro;
        }
        return $this->datos;
    }


//HACES EL LOGIN EN LA BBDD
public function login($usuario,$contrasenia){
    $sql = "SELECT * FROM usuarios WHERE usuario = '" . $usuario . "' and contrasenia = '" . $contrasenia . "' "; 
    if ($consulta = $this->db->query($sql)) { 
        if (mysqli_num_rows($consulta) > 0) { 
            $row = $consulta->fetch_array(MYSQLI_ASSOC);  
            $_SESSION['usuario'] = $row['usuario']; 
            return true;
        } else {          
            return false;
        }
    } else {
        echo 'Fallo en la consulta de la BBDD:' . mysqli_error($this->db);
    }
}

public function insertar($usuario,$contrasenia,$nombre,$apellidos,$correo,$direccion,$telefono){
    $sql="INSERT INTO usuarios (usuario,contrasenia) VALUES ('$usuario','$contrasenia')";
    $consulta = $this->db->query($sql);
    $sql="INSERT INTO datos (usuario,nombre,apellidos,correo,direccion,telefono) VALUES ('$usuario','$nombre','$apellidos','$correo','$direccion','$telefono')";
    $consulta = $this->db->query($sql);
    return $consulta;

    
 }

public  function modificar($usuario,$contrasenia,$nombre,$apellidos,$correo,$direccion,$telefono){
    $sql="UPDATE usuarios SET contrasenia='$contrasenia' WHERE usuario='$usuario'";
    $consulta = $this->db->query($sql);
    $sql="UPDATE datos SET nombre='$nombre', apellidos='$apellidos', correo='$correo', direccion='$direccion', telefono='$telefono' WHERE usuario='$usuario'";
    $consulta = $this->db->query($sql);
    return $consulta;
}
 


public static function obtenerUsuario($id){  
    $sql="SELECT * FROM datos WHERE usuario=$id";
}

//Borras el usuario de la BBDD    
public function borrar($usuario){
    //borrar usuario de la tabla usuarios y de la tabla datos
    $sql= "DELETE FROM usuarios WHERE usuario='$usuario'";
    if(!$consulta = $this->db->query($sql)){
        echo "Error borrar valores en la primera tabla";
    }
    else{
        
    }
    $sql= "DELETE FROM datos WHERE usuario='$usuario'";
    if(!$consulta = $this->db->query($sql)){
        echo "Error borrar valores en la segunda tabla";
    }
    else{
        
    }
}
}




?>
