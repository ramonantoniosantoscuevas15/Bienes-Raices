<?php

namespace Model;

class ActiveRecord{
     //base de datos
     protected static $db;
     protected static $columnasDB = [];

     protected static $tabla='';
      


     //errores
     protected static $erorres =[];
      //public $id;
      //public $titulo;
      //public $precio;
      //public $imagen;
      //public $descripcion;
      //public $habitaciones;
      //public $wc;
      //public $estacionamiento;
      //public $creado;
      //public $vendedores_id;

      

    
     //definir la conexion a la base de datos
    public static function setDB($database){
        self::$db = $database ;

    }

    
    public function guardar(){
        
        if(!is_null($this->id)){
            //actualizando
            $this->actualizar();
        }else{
            //creando un nuevo registro
            $this->crear();
        }
        


    }
    public function crear(){
        //sanitizar los datos
        $atributos = $this->sanitizarAtributos();
       

        //insertar datos 
        $query = "INSERT INTO ". static::$tabla . " (";
        $query.= join(', ',array_keys($atributos));
        $query.= " )
        VALUES (' "; 
        $query.= join("', '",array_values($atributos));
        $query.= " ')";
       
        
        $resultado= self::$db->query($query);

        if($resultado){
            //redireccionar al usuario
            header('Location: /admin?resultado=1');

        
        }
    }
    public function actualizar(){
      //sanitizar los datos
      $atributos = $this->sanitizarAtributos();
      $valores=[];
      foreach($atributos as $key => $value){
        $valores[] = "{$key}='{$value}'";

      }
      $query = "UPDATE " . static::$tabla . " SET ";
      $query.= join(', ', $valores);
      $query.= " WHERE id = '". self::$db->escape_string($this->id). "' ";
      $query.= " LIMIT 1 "; 

      $resultado = self::$db->query($query);

      if($resultado){
        //redireccionar al usuario

    
       }header('Location: /admin?resultado=2');
      

      
    }
    public function eliminar(){
         //elimina la propiedad
         $this->borrarImagen();
         $query = "DELETE FROM " . static::$tabla . " WHERE id = ". self::$db->escape_string($this->id). " LIMIT 1";
         $resultado = self::$db->query($query);
         if($resultado){
            header('location: /admin?resultado=3');
        }
    }
    // identificar y unir los atributos de la BD
    public function atributos(){
        $atributos = [];
        foreach(static::$columnasDB as $columna){
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }
    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizando = [];
        
        foreach($atributos as $key =>$value){
            $sanitizando[$key] = self::$db->escape_string($value);
        }
        return $sanitizando;

    }
    //subida de archivos
    public function setImagen($imagen){
        //elimina la imagen previa
        if(!is_null($this->id)){
            $this->borrarImagen();

        }
        // asignar al atributo de imagen el nombre de la imagen
        $this->imagen = $imagen;
    }
    //eliminar archivo
    public function borrarImagen(){
        //comprobar si existe el archivo
        $existearchivo = file_exists(CARPETA_IMAGENES. $this->imagen);
        if($existearchivo){
            unlink(CARPETA_IMAGENES. $this->imagen);
        }
    }
    //validacion
    public static function getErrores(){
        
        return static::$erorres;
    }
    public function validar(){
        
        static::$erorres= [];
       return static::$erorres;
    }
    //lista todas los registros
    public static function all(){
       $query = "SELECT * FROM ". static::$tabla;
       $resultado= self::consultarSQL($query);
       return $resultado;
      
    }
    //obteniendo numero de registros
    public static function get($cantidad){
        $query = "SELECT * FROM ". static::$tabla. " LIMIT " . $cantidad;
       
        $resultado= self::consultarSQL($query);
        return $resultado;
       
     }

    //busca una propiedad por su id
    public static function find($id){
        $query= "SELECT * FROM " . static::$tabla . " WHERE id = $id";

        $resultado = self::consultarSQL($query);

        return array_shift( $resultado);
    }
    public static function consultarSQL($query){
        //consultar la base de datos
        $resultado = self::$db->query($query);

        //iterar los resultados
        $array=[];
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::crearObjeto($registro);
        }
       
        

        //liberar la memoria
        $resultado->free();

        //retornar los resultados
        return $array;

    }

    protected static function crearObjeto($registro){
        $objeto = new static;

        foreach($registro as $key => $value){
            if(property_exists($objeto,$key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;

    }
    //sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args=[]){
        foreach($args as $key => $value){
            if(property_exists($this,$key) && !is_null($value)){
                $this->$key = $value;
            }
        }

    }
}
