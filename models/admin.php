<?php

namespace Model;

class Admin extends ActiveRecord{
    //Bases de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','email','password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar()
    {
        if(!$this->email){
            self::$erorres[] = 'El Email es obligatorio';
        }
        if(!$this->password){
            self::$erorres[] = 'El Password es obligatorio';
        }

        return self::$erorres;
    }

    public function existeUsuario(){
        //Revisar si un usuario existe
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if(!$resultado->num_rows){
            self::$erorres[] = 'El Usuario no existe';
            return;
        }
        return $resultado;
    }

    public function comprobarPassword($resultado){
        $usuario  = $resultado->fetch_object();

        $autenticado = password_verify($this->password, $usuario->password);

        if(!$autenticado){
            self::$erorres[] = 'El Password es Incorecto';
            
        }
        return $autenticado;

    }

    public function autenticar(){
        session_start();
        //llenar el areglo de session
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }

}