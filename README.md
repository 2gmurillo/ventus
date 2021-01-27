## A CERCA DE ESTE PROYECTO

En este repositorio se encuentra el código fuente del proyecto del RETO DESARROLLADORES JUNIOR II remasterizado. Dicho código fue desarrollado en un sistema operativo GNU/Linux con el framework Laravel en su versión 8.x de PHP

## DESCRIPCIÓN DEL RETO

El administrador de Ventus necesita un sistema que le permita realizar la venta de sus productos de mercadería online. El sistema deberá permitir registrar cada producto así como también administrar las cuentas de sus clientes, quienes también deberán identificarse para realizar compras de los artículos de mercadería. Para el administrador de Amuletto es sumamente importante que el sistema permita realizar pagos online.

## DESARROLLO
### Herramientas utilizadas

Adicional a una terminal de línea de comandos, un editor de código y un navegador web, nuestro sistema operativo GNU/Linux debe contar con:

- **[Apache2](https://httpd.apache.org/)**
- **[MySQL](https://www.mysql.com/)**
- **[PHP](https://www.php.net/)**
- **[phpMyAdmin](https://www.phpmyadmin.net/)** (opcional)
- **[Node.js](https://nodejs.org/es/)**
- **[Composer](https://getcomposer.org/)**
- **[Redis](https://redis.io/)**

Nota: algunas dependencias de Laravel requieren de ciertas extensiones de PHP para funcionar. En caso de que requieras alguna, como por ejemplo BCMath PHP Extension, puedes ejecutar la siguiente sentencia en la terminal de línea de comandos para configurarla:
```bash
$ sudo apt-get install php-bcmath
```

### Configuración de archivos

Este proyecto trabaja con Task Schedule de Laravel, por lo que debe configurarse el binario crontab en el sistema operativo para la ejecución de los cron.

- En la terminal de línea de comandos copiamos lo siguiente:
```bash
$ crontab -e
```
- Escogemos la opción que más nos guste para su modificación (en mi caso escogí nano)
- Copiamos dentro del binario la siguiente estructura y guardamos:
```bash
* * * * * cd "/ruta-del-directorio-de-tu-proyecto" && php artisan schedule:run >> /dev/null 2>&1
```

### Instalación del proyecto

Una vez hayas clonado el repositorio en una nueva carpeta, puedes proceder a ejecutar los siguientes pasos:  
(recuerda que la carpeta donde vas a clonar el repositorio debe contar con los permisos respectivos en tu sistema operativo)
- Dependencias del backend:
```bash
$ composer install
```
- Generación del archivo .env para configuración de las variables de entorno:
```bash
$ cp .env.example .env
```
- Generación de la llave de la aplicación:
```bash
$ php artisan key:generate
```
- Ahora debemos configurar la base de datos en phpMyAdmin y en las variables de entorno que se encuentran en el archivo .env generado anteriormente. En este archivo también debemos configurar las credenciales de Mailtrap y de las pasarelas de pago a utilizar, para mi caso solo PlacetoPay
- Creación del symbolic link para el guardado de archivos:
```bash
$ php artisan storage:link
```
- Migraciones y alimentación de la base de datos:
```bash
$ php artisan migrate --seed
```
- Dependencias del frontend y construcción de assets:
```bash
$ npm install
$ npm run dev
```
- Despliegue:  
```bash
$ php artisan serve
```
- Ahora puedes ver el despliegue en la url: http://localhost:8000/
- Los usuarios y sus contraseñas para el login puedes verlos en el archivo /database/seeds/ProductSeeder.php

Nota: Si no cuentas con [Supervisor](http://supervisord.org/) y su configuración necesaria, debes abrir una nueva terminal y ejecutar el siguiente comando para los jobs:
```bash
$ php artisan queue:work
```
