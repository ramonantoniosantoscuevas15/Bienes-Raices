<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController{
    public static function index(Router $router){
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        //muestra mensaje condicional
        $resultado = $_GET['resultado']??null;
        $router->render('propiedades/admin',[
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]) ;
    }
    public static function crear(Router $router){
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        //arreglo con mensajes de errores
        $erorres = Propiedad::getErrores();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            /**crea una nueva instacia */
            $propiedad = new Propiedad($_POST['propiedad']);
            
            
               /**subida de archivos */
               //crear una carpeta
              //$carpetaImagenes = '../../imagenes';
              //if(!is_dir($carpetaImagenes)){
                //mkdir($carpetaImagenes);
              //}
              // general un nombre unico
              $nombreImagen = md5(uniqid(rand(), true)).".jpg";
              //setear la imagen
              //subir imagen
               //realiza un resize a la imagen con intervention
               if($_FILES['propiedad']['tmp_name']['imagen']){
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
                
        
               }
               
              
               //validar
              $erorres= $propiedad -> validar();
              
           
            
        
            //revisar que el arreglo de erorres este vacio
            if(empty($erorres)){
                
        
                //crear la carpeta para subir imagenes
                if(!is_dir('CARPETA_IMAGENES')){
                    mkdir('CARPETA_IMAGENES');
                }
            
             
                
                //guarda la imagen en el servidor
              // $image->save($carpetaImagenes . $nombreImagen);
              $image->save( CARPETA_IMAGENES. $nombreImagen);
                //guarda en la base de datos
              $propiedad -> guardar();
                
            
                
                
                
        
            }
            
        
        }
        $router->render('propiedades/crear',[
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'erorres' => $erorres

        ]);
    }
    //metodo post para actualizar
    public static function actualizar(Router $router){
        $id = validarORedireccionar('/admin');
        $erorres = Propiedad::getErrores();
        $vendedores = Vendedor::all();
        $propiedad = Propiedad::find($id);
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
   
            //asignal los atributos 
            $args = $_POST['propiedad'];
            $propiedad->sincronizar($args);
           
           
           
            //validacion
            $erorres = $propiedad->validar();
            // general un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)).".jpg";
        
            //subida de archivos
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
                
        
            }
            
            if(empty($erorres)){
                if($_FILES['propiedad']['tmp_name']['imagen']){
                //almacenar la imagen
                 $image->save(CARPETA_IMAGENES . $nombreImagen); 
                }
                 $propiedad->guardar();
              
                
                
                
        
            }
            
        
        }
        $router->render('/propiedades/actualizar',[
            'propiedad' => $propiedad,
            'erorres' => $erorres,
            'vendedores' => $vendedores,
        ]);
    }
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            
                //validar id
                $id = $_POST['id'];
                $id = filter_var($id,FILTER_VALIDATE_INT);
                if($id){
                    $tipo= $_POST['tipo'];
                    if(validarTipoContenido($tipo)){
                        $propiedad = Propiedad::find($id);
                    
                        $propiedad->eliminar();
                    }   
                }
        }
    }
    
}