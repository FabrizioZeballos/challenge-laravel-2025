# 🍽️ API de Gestión de Órdenes - Laravel

## 🧾 Descripción

Construí una API RESTful para la gestión de órdenes de un restaurante, implementada en Laravel 12.15.0, siguiendo principios SOLID, utilizando Eloquent ORM, PostgreSQL como base de datos y Redis para caché. Toda la solución está contenedorizada con Docker para facilitar su ejecución.


## ⚙️ Cómo levantar el proyecto con Docker

  1. Copiar el archivo .env.example a .env.
  2. Completar o ajustar los siguientes campos en el archivo .env:
     - APP_KEY= (clave de la app)
     - DB_PASSWORD= (contraseña de la base de datos)
  3. Ejecutar el siguiente comando para instalar las dependencias de PHP:
    <pre>
     composer install
    </pre>
  5. Ejecutar el siguiente comando para instalar las dependencias de Node:
     <pre>
      npm install
      </pre>
  7. Levantar el proyecto con:
    <pre>
    docker-compose up -d
    </pre>


## 📌 Notas importantes

  - Los seeders y factories se ejecutan automáticamente al correr docker-compose up -d, no es necesario correr nada adicional para poblar la base de datos.
  - El campo total de las órdenes generadas automáticamente por el seeder es un valor aleatorio generado por la factory. Por eso, puede que no coincida con la suma de los precios de los ítems. Sin embargo, al crear una orden manualmente (por ejemplo, desde Postman), el total se calcula correctamente gracias a la lógica implementada en el endpoint correspondiente.
  - Cuando una orden se marca como delivered, se ejecuta Cache::forget('active_orders') para invalidar la caché. Esto asegura que:
    - La orden desaparezca de la lista activa.
    - Se limpie la caché.
    - La siguiente solicitud a GET /api/orders obtenga datos frescos desde la base y los vuelva a cachear.


## ✅ Tests

Se incluyó un test unitario y un test funcional. Se pueden ejecutar con:
<pre>
php artisan test
</pre>


## 📬 Documentación en Postman

Podés probar los endpoints con la colección en Postman:
https://fabrizio-5953688.postman.co/workspace/Fabrizio's-Workspace~9595489f-e72a-4b69-8f02-3b1249f375d6/collection/44995071-646537fd-e937-4530-955c-04313c9a4e73?action=share&creator=44995071



## 🧱 Estructura de la base de datos

Tablas y campos

Order
• client_name
• total
• status

OrderItem
• description
• quantity
• unit_price

Relaciones
• Un Order puede tener muchos OrderItems (uno a muchos).
• Un OrderItem pertenece a un único Order (muchos a uno).



## 🧠 Preguntas opcionales

¿Cómo asegurarías que esta API escale ante alta concurrencia?

Para que la API pueda manejar muchos usuarios al mismo tiempo sin problemas, usaría caching con Redis, que ya está implementado, para reducir la carga en la base de datos. También pondría en marcha queues para procesar tareas pesadas de forma asíncrona y evitar que todo se congestione. Además, optimizaría las consultas.

¿Qué estrategia seguirías para desacoplar la lógica del dominio de Laravel/Eloquent?

La idea sería sacar toda la lógica de negocio de los controladores y modelos, y ponerla en servicios o clases específicas que manejen solo la lógica propia del dominio, sin depender directamente de Laravel o Eloquent. Para eso, usaría repositorios que actúen como una capa intermedia para acceder a los datos, así la lógica principal no está atada al ORM ni a la base de datos, lo que facilita mantenimiento y pruebas.

¿Cómo manejarías versiones de la API en producción?

Para manejar distintas versiones de la API, lo más sencillo y efectivo es hacer versionado en la URL, por ejemplo con /api/v1/orders, /api/v2/orders, etc. Esto permite tener varias versiones activas al mismo tiempo y que los clientes puedan usar la que necesiten sin que se rompa nada. Además, documentaría cada versión y trataría de mantener compatibilidad hacia atrás para que las actualizaciones no afecten a quienes ya usan versiones anteriores.
