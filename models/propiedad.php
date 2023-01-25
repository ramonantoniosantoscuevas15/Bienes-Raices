<?php

namespace Model;

class Propiedad extends ActiveRecord {
    
    protected static $tabla='propiedades';
    protected static $columnasDB = ['id','titulo','precio','imagen','descripcion'
    ,'habitaciones','wc','estacionamiento','creado','vendedores_id'];
    
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }
    public function validar(){
        if(!$this->titulo){
            self::$erorres[] = "Debes añadir un titulo";
        }
        if(!$this->precio){
            self::$erorres[] = "El precio es obligatorio";
        }
        if(strlen($this->descripcion) < 50){
            self::$erorres[] = "La descripcion es obligatoria y debes tener al menos 50 caracteres";
        }
        if(!$this->habitaciones){
            self::$erorres[] = "Las habitaciones son obligatorias";
        }
        if(!$this->wc){
            self::$erorres[] = "Los baños son obligatorias";
        }
        if(!$this->estacionamiento){
            self::$erorres[] = "El numero de lugares de estacionamiento es obligatorio";
        }
        if(!$this->vendedores_id){
            self::$erorres[] = "Elige un vendedor";
        }
        if(!$this->imagen){
            self::$erorres[] = 'La imagen es obligatoria';
    
        }
        
       return self::$erorres;
    }
}