# Proyecto Marvel Covalto

Este proyecto es una aplicación web que utiliza la API pública de Marvel para mostrar un CRUD de personajes. Está construido con CodeIgniter 4 y MySQL.

## Requisitos

- PHP 7.4 o superior
- Composer
- MySQL o MariaDB
- Un servidor web (Apache, Nginx, etc.)

## Instalación Local

Sigue estos pasos para instalar el proyecto en tu entorno local:

1. **Descarga el Proyecto**

   Extrae el archivo zip del proyecto en el directorio de tu elección.

2. **Instala las Dependencias**

   Renombra el archivo .env.example a .env.
    Abre el archivo .env y ajusta las siguientes configuraciones:
    app.baseURL - Cambia la URL base según el entorno local si es necesario.
    database.default.hostname - Cambia la dirección del servidor de base de datos si no estás usando localhost.
    database.default.username y database.default.password - Introduce las credenciales correctas para tu base de datos.

3. **Instala las Dependencias PHP**

    Abre una terminal y navega al directorio del proyecto. Ejecuta el siguiente comando para instalar las dependencias de PHP:

    composer install

4. **Instala las BD**

    Configurar la Base de Datos

    Importa el archivo SQL a tu base de datos

5. **Acceder a la Aplicación**

    