<?php
    // $nombre ="Pepito";  //string
    // $edad = 15;         //integer
    // $precio =19.99;     //float
    // $esActivo = true;   //Boolean

    // echo "<h1>Bienvenido a la clase de PHP, $nombre </h1>";
    // echo "<p>Edad: $edad años</p>";
    // echo "<p>Pecio: $precio</p>";
    // echo "<p>Activo:".($esActivo ? 'verdadero':'false'). "</p>";
    // echo "<hr>";

    // //condicionales
    // if($edad>=18){
    //     echo "$nombre es mayor de edad";
    // }else{
    //     echo "$nombre es menor de edad";
    // }


    // //Bucles
    // //for
    // for($i=1;$i<=5;$i++){
    //     echo "<p>Iteración número: $i</p>";
    // }
    // //while
    // $contador = 0;
    // while ($contador < 5) {
    //     echo $contador;
    //     $contador++;
    // }
    // //Arrays
    // $frutas=["Manzana","Pera","Cereza","Durazno"];

    // echo "<h2>Recorrer Array</h2>";
    // foreach($frutas as $fruta){
    //     echo "<p>Fruta: $fruta</p>";
    // }

    // //Funciones
    // function sumar($a,$b){
    //     return $a + $b;
    // }

    // $num1 =2;
    // $num2=3;
    // $suma=sumar($num1,$num2);
    // echo "<p>La suma de $num1 y $num2 es: $suma</p>";
    

    // //Clases
    // class Persona{
    //     public $nombre;
    //     public $edad;
        
    //     public function __construct($nombre,$edad)
    //     {
    //         $this->nombre=$nombre;
    //         $this->edad=$edad;
    //     }
    //     public function saludar(){
    //         return "Hola, mi nombre es $this->nombre y tengo $this->edad años";
    //     }
    // }

    // // Definir las variables
    // $numero1 = 15;
    // $numero2 = 5;
    // $operacion = "resta"; // Puede ser "suma", "resta", "multiplicacion" o "division"

    // // Función para saludar al usuario
    // function saludoCalculadora($nombre) {
    //     return "¡Hola, " . $nombre . "! Aquí tienes el resultado de tu operación: <br>";
    // }

    // // Mostrar el saludo
    // echo saludoCalculadora("Estudiante");

    // // Estructura de control para la operación
    // if ($operacion == "suma") {
    //     echo "Resultado de la suma: " . ($numero1 + $numero2);
    // } elseif ($operacion == "resta") {
    //     echo "Resultado de la resta: " . ($numero1 - $numero2);
    // } elseif ($operacion == "multiplicacion") {
    //     echo "Resultado de la multiplicación: " . ($numero1 * $numero2);
    // } elseif ($operacion == "division") {
    //     // Asegurarse de que no se divide por cero
    //     if ($numero2 != 0) {
    //         echo "Resultado de la división: " . ($numero1 / $numero2);
    //     } else {
    //         echo "No se puede dividir entre cero.";
    //     }
    // } else {
    //     echo "Operación no válida.";
    // }

    class automovil {
        // 1. Propiedades de la clase
        // Las propiedades representan las características del automovil
        public $modelo;     
        public $color;      
        public $velocidad; 
        
        public function __construct($modelo, $color) {
            $this->modelo = $modelo;  
            $this->color = $color;    
            $this->velocidad = 0;     
        }
    
        public function acelerar($incremento) {
            $this->velocidad += $incremento; 
            return "El automovil ha acelerado a $this->velocidad km/h.";
        }
    
        public function frenar($decremento) {
            $this->velocidad -= $decremento;
            if ($this->velocidad < 0) {
                $this->velocidad = 0;
            }
            return "El automovil ha frenado y su velocidad es $this->velocidad km/h.";
        }
    
        public function mostrarEstado() {
            return "Modelo: $this->modelo, Color: $this->color, Velocidad: $this->velocidad km/h.";
        }
    }
    
    echo "<h1>Clase Vehiculo</h1>";
    
    // Creamos un objeto de la clase automovil con modelo "Toyota Corolla" y color "Rojo"
    $automovil = new automovil("Toyota Corolla", "Rojo");
    
    // 7. Llamada a los Métodos
    // Llamamos al método mostrarEstado() para ver el estado inicial del automovil
    echo "<p>" . $automovil->mostrarEstado() . "</p>";
    
    // Aceleramos el automovil en 50 km/h
    echo "<p>" . $automovil->acelerar(50) . "</p>";
    
    // Volvemos a mostrar el estado del automovil
    echo "<p>" . $automovil->mostrarEstado() . "</p>";
    
    // Frenamos el automovil en 20 km/h
    echo "<p>" . $automovil->frenar(20) . "</p>";
    
    // Volvemos a mostrar el estado del automovil
    echo "<p>" . $automovil->mostrarEstado() . "</p>";

?>
