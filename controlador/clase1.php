<?php
// Al inicio usamos `<?php` para indicar que empieza el código PHP

// 1. Variables y tipos de datos
// Definimos algunas variables con diferentes tipos de datos
$nombre = "Juan"; // String (cadena de texto)
$edad = 30;       // Integer (número entero)
$precio = 19.99;  // Float (número decimal)
$esActivo = true; // Boolean (valor verdadero o falso)

// Usamos `echo` para imprimir texto en el navegador
echo "<h1>Bienvenido a la clase de PHP, $nombre!</h1>"; // Mostramos el nombre
echo "<p>Edad: $edad años</p>";                        // Mostramos la edad
echo "<p>Precio: $precio</p>";                          // Mostramos el precio
echo "<p>Activo: " . ($esActivo ? 'Sí' : 'No') . "</p>"; // Mostramos si está activo o no
echo "<hr>"; // Línea horizontal para separar secciones

// 2. Condicionales
// Usamos `if` para hacer decisiones en función de la edad
if ($edad >= 18) {
    // Si la edad es 18 o mayor, se muestra este mensaje
    echo "<p>$nombre es mayor de edad.</p>";
} else {
    // Si la edad es menor de 18, se muestra este mensaje
    echo "<p>$nombre es menor de edad.</p>";
}

// 3. Bucles
// Ahora mostramos un ejemplo de un bucle `for`
echo "<h2>Bucle For</h2>";
// El bucle `for` empieza en 1 y termina en 5, incrementándose en cada iteración
for ($i = 1; $i <= 5; $i++) {
    echo "<p>Iteración número: $i</p>"; // Mostramos el número de cada iteración
}

// 4. Arrays
// Creamos un array llamado `$frutas` que contiene varios elementos
$frutas = ["Manzana", "Banana", "Cereza", "Durazno"];

echo "<h2>Frutas</h2>";
// Usamos un bucle `foreach` para recorrer cada elemento del array `$frutas`
foreach ($frutas as $fruta) {
    echo "<p>Fruta: $fruta</p>"; // Mostramos cada fruta
}

// 5. Funciones
// Definimos una función llamada `sumar` que toma dos parámetros y retorna su suma
function sumar($a, $b) {
    return $a + $b; // Retorna la suma de los dos números
}

echo "<h2>Funciones</h2>";
// Creamos dos variables para usar en la función `sumar`
$numero1 = 10;
$numero2 = 20;
// Llamamos a la función `sumar` y guardamos el resultado en `$suma`
$suma = sumar($numero1, $numero2);
echo "<p>La suma de $numero1 y $numero2 es: $suma</p>"; // Mostramos el resultado

// 6. Clases y objetos
// Definimos la clase "Persona"
// Una clase es un conjunto de instrucciones que define cómo crear un "objeto" de ese tipo.
class Persona {
    // 1. Propiedades de la clase
    // Las propiedades son como variables que pertenecen a la clase
    // Definimos dos propiedades, `nombre` y `edad`, para cada persona que creemos.
    public $nombre; // Esta propiedad guardará el nombre de la persona
    public $edad;   // Esta propiedad guardará la edad de la persona

    // 2. El Constructor
    // Un constructor es una función especial que se ejecuta automáticamente
    // cuando creamos un nuevo objeto de la clase.
    public function __construct($nombre, $edad) {
        // `this` se refiere al objeto que estamos creando
        // Asignamos los valores que recibimos ($nombre y $edad) a las propiedades del objeto
        $this->nombre = $nombre; // Guardamos el nombre pasado como parámetro
        $this->edad = $edad;     // Guardamos la edad pasada como parámetro
    }

    // 3. Método saludar()
    // Un método es una función que pertenece a la clase y que el objeto puede usar
    public function saludar() {
        // Este método retorna un mensaje con el nombre y la edad de la persona
        return "Hola, mi nombre es $this->nombre y tengo $this->edad años.";
    }
}

// 4. Creación de un Objeto
// Usamos la clase "Persona" para crear un objeto específico
$persona1 = new Persona("Ana", 25); // Creamos un objeto de la clase Persona con nombre "Ana" y edad 25

// 5. Llamada al Método
// Llamamos al método `saludar` de nuestro objeto `persona1` y mostramos el mensaje
echo "<h1>Clase Persona</h1>";
echo "<p>" . $persona1->saludar() . "</p>";


// Definimos la clase "automovil"
class automovil {
    // 1. Propiedades de la clase
    // Las propiedades representan las características del automovil
    public $modelo;     // Guarda el modelo del automovil
    public $color;      // Guarda el color del automovil
    public $velocidad;  // Guarda la velocidad actual del automovil

    // 2. Constructor
    // El constructor inicializa las propiedades del automovil al momento de crearlo
    public function __construct($modelo, $color) {
        $this->modelo = $modelo;  // Asignamos el modelo del automovil
        $this->color = $color;    // Asignamos el color del automovil
        $this->velocidad = 0;     // Inicializamos la velocidad en 0
    }

    // 3. Método acelerar()
    // Este método incrementa la velocidad del automovil
    public function acelerar($incremento) {
        $this->velocidad += $incremento; // Aumenta la velocidad en el valor recibido
        return "El automovil ha acelerado a $this->velocidad km/h.";
    }

    // 4. Método frenar()
    // Este método reduce la velocidad del automovil
    public function frenar($decremento) {
        // Aseguramos que la velocidad no sea negativa
        $this->velocidad -= $decremento;
        if ($this->velocidad < 0) {
            $this->velocidad = 0;
        }
        return "El automovil ha frenado y su velocidad es $this->velocidad km/h.";
    }

    // 5. Método mostrarEstado()
    // Este método muestra el estado actual del automovil
    public function mostrarEstado() {
        return "Modelo: $this->modelo, Color: $this->color, Velocidad: $this->velocidad km/h.";
    }
}

echo "<h1>Clase Autos</h1>";

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