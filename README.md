# **Desarrollo y Despliegue de API REST con Laravel, PostgreSQL y Docker**

## **1. Configuración del Entorno de Desarrollo**
### 🔹 **Instalación de Laravel**
Ejecuté el siguiente comando para crear el proyecto:

```bash
composer create-project --prefer-dist laravel/laravel api-service
cd api-service
```

#### **🔴 Problema:** Composer no estaba instalado  
**✅ Solución:** Lo instalé con:
```bash
sudo apt install composer -y
```

#### **🔴 Problema:** Permisos de directorios  
Después de instalar Laravel, tuve problemas con permisos en la carpeta `storage` y `bootstrap/cache`.

**✅ Solución:**
```bash
chmod -R 777 storage bootstrap/cache
```

---

## **2. Configuración de PostgreSQL**
Modifiqué el archivo `.env` para configurar la base de datos:

```ini
DB_CONNECTION=pgsql
DB_HOST=postgres_db
DB_PORT=5432
DB_DATABASE=api_database
DB_USERNAME=api_user
DB_PASSWORD=secret
```

Ejecuté las migraciones:
```bash
php artisan migrate
```

#### **🔴 Problema:** Error `SQLSTATE[08006] could not translate host name "postgres_db"`  
**✅ Solución:**  
- **Verifiqué si el contenedor estaba corriendo:**  
  ```bash
  docker ps
  ```
- **Esperé unos segundos y lo volvió a intentar**, ya que el servicio de PostgreSQL a veces tarda en iniciarse.

#### **🔴 Problema:** Acceso denegado al usuario de PostgreSQL  
**✅ Solución:**  
Ingresé manualmente a PostgreSQL y cambié la contraseña:
```bash
docker exec -it postgres_db psql -U postgres
ALTER USER api_user WITH PASSWORD 'secret';
```

---

## **3. Creación del CRUD de Productos y Categorías**
1. Generé los modelos y controladores:
   ```bash
   php artisan make:model Product -mcr
   php artisan make:model Category -mcr
   ```

2. Definí las rutas en `routes/api.php`:
   ```php
   Route::apiResource('produDesarrollo y Despliegue de API REST con Laravel, PostgreSQL y Docker
1. Configuración del Entorno de Desarrollo
🔹 Instalación de Laravel

Ejecuté el siguiente comando para crear el proyecto:

composer create-project --prefer-dist laravel/laravel api-service
cd api-service

🔴 Problema: Composer no estaba instalado

✅ Solución: Lo instalé con:

sudo apt install composer -y

🔴 Problema: Permisos de directorios

Después de instalar Laravel, tuve problemas con permisos en la carpeta storage y bootstrap/cache.

✅ Solución:

chmod -R 777 storage bootstrap/cache

2. Configuración de PostgreSQL

Modifiqué el archivo .env para configurar la base de datos:

DB_CONNECTION=pgsql
DB_HOST=postgres_db
DB_PORT=5432
DB_DATABASE=api_database
DB_USERNAME=api_user
DB_PASSWORD=secret

Ejecuté las migraciones:

php artisan migrate

🔴 Problema: Error SQLSTATE[08006] could not translate host name "postgres_db"

✅ Solución:

    Verifiqué si el contenedor estaba corriendo:

    docker ps

    Esperé unos segundos y lo volví a intentar, ya que el servicio de PostgreSQL a veces tarda en iniciarse.

🔴 Problema: Acceso denegado al usuario de PostgreSQL

✅ Solución:
Ingresé manualmente a PostgreSQL y cambié la contraseña:

docker exec -it postgres_db psql -U postgres
ALTER USER api_user WITH PASSWORD 'secret';

3. Creación del CRUD de Productos y Categorías

    Generé los modelos y controladores:

php artisan make:model Product -mcr
php artisan make:model Category -mcr

Definí las rutas en routes/api.php:

    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);

    Probé los endpoints en Postman enviando solicitudes GET, POST, PUT y DELETE.

🔴 Problema: Laravel devolvía un error 404 en las rutas de la API

✅ Solución:
Ejecuté php artisan route:list para verificar si las rutas estaban registradas correctamente.
🔴 Problema: No se guardaban datos en la base de datos

✅ Solución:
El problema era que no estaba añadiendo los campos en $fillable en el modelo. Lo corregí agregando:

protected $fillable = ['name', 'price', 'category_id'];

4. Dockerización del Proyecto

    Creé el archivo Dockerfile para construir la imagen de Laravel.
    Configuré docker-compose.yml para levantar PostgreSQL, Laravel y Nginx.

Para levantar los contenedores, ejecuté:

docker-compose up -d

🔴 Problema: Error could not translate host name "postgres_db"

✅ Solución:

    Esperé unos segundos después de levantar los contenedores.
    Verifiqué la red con:

    docker network ls
    docker network inspect api-service_default

🔴 Problema: Laravel no tenía permisos en storage/logs/laravel.log

✅ Solución:

chmod -R 777 storage bootstrap/cache

5. Subida del Código a GitHub

    Inicialicé Git en el proyecto:

    git init
    git remote add origin https://github.com/JeXps/api-service.git
    git add .
    git commit -m "Primer commit"

🔴 Problema: Git mostraba el error "Identidad del autor desconocida"

✅ Solución: Configuré mi usuario y correo en Git:

git config --global user.name "JeXps"
git config --global user.email "jexps@example.com"

    Intenté hacer git push, pero falló por credenciales.
    ✅ Solución: Configuré SSH en GitHub y lo subí correctamente con:

    git remote set-url origin git@github.com:JeXps/api-service.git
    git push -u origin main

6. Pruebas con Postman y Exportación del Archivo JSON

    Probé la API en Postman, enviando peticiones a:

GET http://localhost/api/products
POST http://localhost/api/products
PUT http://localhost/api/products/{id}
DELETE http://localhost/api/products/{id}

Exporté la colección en un archivo JSON:

    Fui a Collections en Postman.
    Seleccioné mi colección y la exporté en formato v2.1.
    Guardé el archivo api-service.postman_collection.json para incluirlo en la entrega.cts', ProductController::class);
   Route::apiResource('categories', CategoryController::class);
   ```

3. Probé los endpoints en **Postman** enviando solicitudes GET, POST, PUT y DELETE.

#### **🔴 Problema:** Laravel devolvía un error 404 en las rutas de la API  
**✅ Solución:**  
Ejecuté `php artisan route:list` para verificar si las rutas estaban registradas correctamente.

#### **🔴 Problema:** No se guardaban datos en la base de datos  
**✅ Solución:**  
El problema era que no estaba añadiendo los campos en `$fillable` en el modelo. Lo corregí agregando:
```php
protected $fillable = ['name', 'price', 'category_id'];
```

---

## **4. Dockerización del Proyecto**
1. Creé el archivo `Dockerfile` para construir la imagen de Laravel.  
2. Configuré `docker-compose.yml` para levantar PostgreSQL, Laravel y Nginx.

Para levantar los contenedores, ejecuté:
```bash
docker-compose up -d
```

#### **🔴 Problema:** Error `could not translate host name "postgres_db"`  
**✅ Solución:**  
- Esperé unos segundos después de levantar los contenedores.
- Verifiqué la red con:
  ```bash
  docker network ls
  docker network inspect api-service_default
  ```

#### **🔴 Problema:** Laravel no tenía permisos en `storage/logs/laravel.log`  
**✅ Solución:**  
```bash
chmod -R 777 storage bootstrap/cache
```

---

## **5. Subida del Código a GitHub**
1. Inicialicé Git en el proyecto:
   ```bash
   git init
   git remote add origin https://github.com/JeXps/api-service.git
   git add .
   git commit -m "Primer commit"
   ```

#### **🔴 Problema:** Git mostraba el error "Identidad del autor desconocida"  
**✅ Solución:** Configuré mi usuario y correo en Git:
```bash
git config --global user.name "JeXps"
git config --global user.email "jexps@example.com"
```

2. Intenté hacer `git push`, pero falló por credenciales.  
   **✅ Solución:** Configuré SSH en GitHub y lo subí correctamente con:
   ```bash
git remote set-url origin git@github.com:JeXps/api-service.git
git push -u origin main
   ```

---

## **6. Pruebas con Postman y Exportación del Archivo JSON**
1. Probé la API en **Postman**, enviando peticiones a:
   ```
   GET http://localhost/api/products
   POST http://localhost/api/products
   PUT http://localhost/api/products/{id}
   DELETE http://localhost/api/products/{id}
   ```

2. Exporté la colección en un archivo JSON:
   - Fui a **Collections** en Postman.
   - Seleccioné mi colección y la exporté en formato **v2.1**.
   - Guardé el archivo `api-service.postman_collection.json` para incluirlo en la entrega.

---

## **7. Documentación y Entrega Final**
- **Repositorio GitHub:** ✅  
- **Capturas de PostgreSQL:** ✅  
- **Archivo Postman (.json):** ✅  
- **Dockerfile y docker-compose.yml:** ✅  
- **URL del servicio desplegado:** ✅  
- **Informe PDF:** En proceso...

---

✅ **¡Proyecto completado con éxito!** 🎯





































<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
