<?php

namespace Controllers;
use MVC\Router;
use Model\Vendedor;
class VendedorController{
    public static function crear(Router $router){
        $erorres= Vendedor::getErrores();
        $vendedor = new Vendedor;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //crear una nueva instancia
            $vendedor = new vendedor($_POST['vendedor']);
            //validar que no haya campos vacios
            $erorres = $vendedor->validar();
            //no hay errores
            if(empty($erorres)){
               $vendedor->guardar();
            }
           }
        $router->render('vendedores/crear',[
            'erorres' =>$erorres, 
            'vendedor' => $vendedor

        ]);
    }
    public static function actualizar(Router $router){
        $erorres= Vendedor::getErrores();
        $id = validarORedireccionar('/admin');
        $vendedor =  Vendedor::find($id);
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //asignar los valores
            $args = $_POST['vendedor'];
            
            //sincronizar objeto en memoria con lo que el usuario escribio
            $vendedor->sincronizar($args);
            //validacion
            $erorres = $vendedor->validar();
        
            if(empty($erorres)){
                $vendedor->guardar();
            }
        
        }
        $router->render('/vendedores/actualizar',[
            'erorres' =>$erorres, 
            'vendedor' => $vendedor

        ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            
            //valida el id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){
               //valida el tipo a eliminar
               $tipo= $_POST['tipo'];
               if(validarTipoContenido($tipo)){
                 $vendedor = Vendedor::find($id);
                 $vendedor->eliminar();
               }

            }
        }
    }
}