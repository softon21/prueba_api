Prueba API Marc Ibi
========

## Para descargar en local ##
- git clone https://github.com/softon21/prueba_api.git
- composer install
- Para lanzar la aplicación: ``` php -S 127.0.0.1:8000 -t public ```


## Directorio de rutas ##

Todo lo relacionado con la API estará dentro de la ruta /api de la aplicación

- Ruta para pintar la lista de recetas:

    - Hay que acceder mediante GET a través de /recipes
    
    - Es necesario enviar un parámetro, el cual se usará para obtener el tipo de recetas a motrar (carne, pescado, vegetariano, etc)
   
    - En esta versión todavía no está implementada la búsqueda de recetas por tipo ya que la API de Recipe Puppy no devuelve esta información
    
    - Ejemplo de llamada: /api/recipes/vegan
    

    