# CRUD Empleados
Proyecto de gestión de empleados desarrollado con Laravel, PHP y MySQL.

## TECNOLOGÍAS USADAS
**Backend:** Laravel Framework 12.26.2  
**Lenguaje:** PHP 8.2.12  
**Base de datos:** MySQL  
**Frontend / JavaScript:** Node.js v22.16.0  
**Plantillas / UI:** Blade, Bootstrap 5 

## REQUISITOS
- PHP >= 8.2  
- Composer  
- Node.js >= 22  
- MySQL  
- Navegador web moderno  

## INSTALACIÓN
1. Clonar el repositorio:
git clone https://github.com/JossAr10/prueba_nexura.git
2. Entrar al proyecto
cd prueba_nexura

## INSTALAR DEPENDENCIAS PHP:
composer install

## INSTALAR DEPENDENCIAS NODE
npm install

## COPIAR EL ARCHIVO .env.example A .env
cp .env.example .env

## CONFIGURAR EL ARCHIVO .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crud_empleados
DB_USERNAME=root
DB_PASSWORD=tu_contraseña

## GENERAR CLAVE DE LA APLICACION
php artisan key:generate

## VALIDAR QUE EN EL ARCHIVO .env POSEA VALOR LA VARIABLE APP_KEY

## CREAR BD MYSQL, EJECUTAR DIRECTAMENTE EN MYSQL
CREATE DATABASE crud_empleados
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

## MIGRACIONES
## PARA MIGRAR LAS TABLAS A LA BD. PARA CREAR LAS TABLAS EN LA BD 
php artisan migrate

## SI NECESITA DATOS DE PRUEBAS ALEATORIOS
php artisan db:seed

## LEVANTAR SEVIDOR LOCAL
php artisan serve

## COPIAR URL EN EL NAVEGADOR
http://127.0.0.1:8000/empleados