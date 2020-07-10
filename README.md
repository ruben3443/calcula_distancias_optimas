## Instrucciones de ejecución

El proyecto se ejecuta entrando con el navegador en el fichero "index.php" e indicando la ciudad de origen y destino por parámetro.

Ejemplo: Origen Logroño y destino Ciudad Real
    /index.php?city1=Logroño&city2=Ciudad Real
    
Si no se indica una ciudad de destino (/index.php?city1=Logroño) se mostrarán los caminos mínimos a todas las ciudades listadas en el fichero de datos.

Si no se indica ni origen ni destino (/index.php?) saldrá un mensaje de advertencia.


## Composición del proyecto

Fichero index.php:
    Raiz del proyecto. Extrae los datos de la URL, los datos almacenados en el fichero data.php, hace las llamadas a la librería creada especificamente para el proyecto y muestra el resultado en el navegador.
    
Fichero data.php:
    Aquí se almacena la lista de ciudades y la matriz multidimensional que contiene las distancias entre todos los lugares (si no hay camino entre dos sitios será 0).
    
Fichero calcula_distancias.php:
    Librería donde se hace el tratamiento de datos y se calculan las distancias y los caminos mínimos.