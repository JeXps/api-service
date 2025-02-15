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

✅ Solución: 

    Intenté hacer git push, pero falló por credenciales.
    ✅ Solucion 
    En lugar de ingresar usuario y contraseña, se utilizó GitHub CLI para autenticarse correctamente:
    gh auth login
    Este comando permite iniciar sesión en GitHub desde la terminal y enlazar la cuenta correctamente.
    Tras autenticarse, el comando git push -u origin main funcionó sin problemas.

6. Pruebas con Postman y Exportación del Archivo JSON

    Probé la API en Postman, enviando peticiones a:

GET http://localhost/api/categories
POST http://localhost/api/categories
PUT http://localhost/api/categories/{id}
DELETE http://localhost/api/categories/{id}

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

## **6. Pruebas con Postman y Exportación del Archivo JSON**
1. Probé la API en **Postman**, enviando peticiones a:
   ```
   GET http://localhost/api/products
   POST http://localhost/api/products
   PUT http://localhost/api/products/{id}
   DELETE http://localhost/api/products/{id}
   ```
2. Exporté la colección en un archivo JSON:
---
 - Fui a **Collections** en Postman.
   - Seleccioné mi colección y la exporté en formato **v2.1**.
   - Guardé el archivo `api-service.postman_collection.json` para incluirlo en la entrega.

---
