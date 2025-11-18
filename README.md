# FacturadorPHP
Aplicación para creación de facturas en PDF, hecho con HTML, CSS, JS, PHP y MySQL.

## Resumen

Aplicación web ligera para la gestión de clientes, productos y facturas.
Utiliza un **patrón MVC propio**, peticiones **AJAX** para una interacción dinámica y **Bootstrap + SweetAlert2** para una mejor experiencia de usuario.
Las facturas pueden descargarse en **PDF** mediante la librería **FPDF**.

## Estado del proyecto

* Arquitectura inicial implementada y rutas configuradas (URLs amigables vía `.htaccess`).
* CRUD completo para:

  * **Clientes**
  * **Productos**
  * **Facturas** (cabecera + detalle)
* Generación de PDF funcional.
* Sistema de notificaciones en frontend (SweetAlert2).
* Integración AJAX corregida para mejorar la limpieza de formularios y mostrar mensajes en el orden adecuado.

## Tecnologías utilizadas

* **PHP 7.4+** (procedural y POO según módulos).
* **MySQL / MariaDB**.
* **PDO** para el manejo seguro de base de datos.
* **JavaScript** (AJAX con `Ajax.js`).
* **Bootstrap 5** y **SweetAlert2**.
* **FPDF** para generación de comprobantes en PDF.
* **Apache con mod_rewrite** para friendly URLs.

## Requisitos

* PHP ≥ 7.4
* Extensiones: `pdo`, `pdo_mysql`, `gd` (opcional para logos/imágenes).
* MySQL/MariaDB.
* Servidor Apache con `mod_rewrite` habilitado.
* Composer (opcional).

## Instalación rápida

1. **Clonar el repositorio:**

```bash
git clone https://github.com/TecnoZoni/FacturadorPHP.git
cd facturadorPHP
```

2. **Importar la base de datos:**

   * Importar `facturador.sql` desde phpMyAdmin (crea automáticamente la BD).

3. **Configurar credenciales en `config/server.php`:**

```php
<?php
const DB_SERVER = 'localhost';
const DB_NAME = 'facturador';
const DB_USER = 'root';
const DB_PASSWORD = '';
```

4. **Iniciar la aplicación:**

   * Acceder a:
     `http://localhost/facturadorPHP`

---

## Estructura de archivos (resumen)

```
/ (raíz del proyecto)         # Punto de entrada del sistema y archivos principales
├─ app/           # Núcleo de la aplicación (MVC + recursos)
│  ├─ ajax/          # Controladores específicos para manejar solicitudes AJAX
│  ├─ controllers/         # Controladores principales del sistema (Clientes, Productos, Facturas, Perfil)
│  ├─ library/       # Librerías externas (FPDF para generación de PDFs)
│  ├─ models/        # Modelos de datos (mainModel, viewModel, clases de acceso a BD)
│  ├─ views/         # Vistas y plantillas que componen la interfaz de usuario
│     ├─ content/       # Contenido principal de vistas (listas, formularios, paneles, etc.)
│     ├─ css/           # Estilos personalizados de la aplicación
│     ├─ fotos/         # Imagen/logo correspondiente a la empresa configurada
│     ├─ img/        # Iconos e imágenes utilizadas por la aplicación
│     ├─ inc/        # Fragmentos PHP reutilizables (header, footer, sidebar, etc.)
│     ├─ js/         # Scripts JS específicos de las vistas
│     └─ utils/         # Recursos adicionales (ej. Bootstrap Icons)
├─ config/        # Archivos de configuración base del proyecto
│  ├─ server.php        # Configuración de conexión a la base de datos
│  └─ app.php        # Configuración general (paths, constantes globales, etc.)
├─ .htaccess         # Reglas de URL amigables y configuración de Apache
├─ autoload.php         # Cargador automático de clases/controladores/modelos
├─ Facturador.exe       # Ejecutable para iniciar XAMPP + abrir app (automatización)
├─ facturador.sql          # Script SQL con la estructura de la base de datos
├─ index.php         # Archivo de entrada principal de la aplicación (front controller)
└─ README.md         # Documentación del proyecto
```

---

# Esquema de Base de Datos

Basado completamente en `facturador.sql` del proyecto.

## Tablas principales

### **1. cliente**

| Campo            | Tipo                   | Descripción               |
| ---------------- | ---------------------- | ------------------------- |
| cliente_id (PK)  | int(11) AUTO_INCREMENT | Identificador del cliente |
| cliente_nombre   | varchar(100)           | Nombre                    |
| cliente_apellido | varchar(100)           | Apellido                  |
| cliente_telefono | varchar(20)            | Teléfono                  |
| cliente_email    | varchar(100)           | Email                     |

---

### **2. producto**

| Campo                    | Tipo                   | Descripción         |
| ------------------------ | ---------------------- | ------------------- |
| producto_id (PK)         | int(11) AUTO_INCREMENT | ID del producto     |
| producto_codigo (UNIQUE) | varchar(50)            | Código interno      |
| producto_nombre          | varchar(100)           | Nombre del producto |
| producto_precio          | decimal(10,2)          | Precio unitario     |
| producto_descripcion     | text                   | Descripción         |

---

### **3. factura**

| Campo           | Tipo                   | Descripción          |
| --------------- | ---------------------- | -------------------- |
| factura_id (PK) | int(11) AUTO_INCREMENT | ID factura           |
| cliente_id (FK) | int(11)                | Referencia a cliente |
| factura_fecha   | datetime               | Fecha (default NOW)  |
| factura_total   | decimal(10,2)          | Total calculado      |

**Relación:**
`factura.cliente_id → cliente.cliente_id`

---

### **4. detalle_factura**

| Campo                           | Tipo                   | Descripción           |
| ------------------------------- | ---------------------- | --------------------- |
| detalle_factura_id (PK)         | int(11) AUTO_INCREMENT | Ítem detalle          |
| factura_id (FK)                 | int(11)                | Referencia a factura  |
| producto_id (FK)                | int(11)                | Referencia a producto |
| detalle_factura_cantidad        | int(11)                | Unidades              |
| detalle_factura_precio_unitario | decimal(10,2)          | Precio del producto   |
| detalle_factura_subtotal        | decimal(10,2)          | Cantidad × precio     |

**Relaciones:**

* `detalle_factura.factura_id → factura.factura_id`
* `detalle_factura.producto_id → producto.producto_id`

---

### **5. configuracion**

Configuración general del sistema / datos de la empresa.

| Campo                          | Tipo                   | Descripción      |
| ------------------------------ | ---------------------- | ---------------- |
| configuracion_id (PK)          | int(11) AUTO_INCREMENT | ID               |
| configuracion_nombre           | varchar(100)           | Nombre comercial |
| configuracion_logo             | varchar(255)           | Ruta a imagen    |
| configuracion_telefono         | varchar(20)            | Teléfono         |
| configuracion_email            | varchar(100)           | Email            |
| configuracion_cuit             | varchar(20)            | CUIT             |
| configuracion_direccion        | text                   | Dirección        |
| configuracion_inicio_actividad | date                   | Fecha alta AFIP  |

---

# Diagrama lógico (texto)

```
cliente (1) ----- (N) factura (1) ----- (N) detalle_factura ----- (1) producto
```

---

## Uso y flujo típico

1. Registrar clientes.
2. Registrar productos.
3. Crear una factura:

   * Seleccionar cliente.
   * Agregar productos dinámicamente vía AJAX.
4. Guardar factura y generar PDF.
5. Descargar o imprimir el comprobante.

Las respuestas AJAX devuelven JSON y el frontend maneja notificaciones con SweetAlert2.

---

## Contribución

* Crear issues para reportar bugs o solicitar nuevas features.
* Enviar pull requests hacia `main`.

---

# 2. Documentación de arquitectura

## Objetivo

Describir la arquitectura actual para facilitar mantenimiento, extensión y onboarding de otros desarrolladores.

## Patrón general

* **MVC ligero**: Separación entre *models* (acceso a datos), *controllers* (lógica) y *views* (presentación).
* **AJAX**: Para operaciones CRUD en la interfaz y para crear experiencia dinámica sin recargas completas.
* **Routing**: Gestor simple via `.htaccess` y un front-controller (index.php que carga vistas según rutas amigables).

## Capas / Componentes

1. **Capa de Presentación (Views)**

   * Archivos PHP que contienen plantillas HTML y llamadas a JS/CSS.
   * Vistas importantes: `dashboard`, `clientList`, `clientNew`, `invoiceList`, `invoiceNew`, `invoiceEdit`, `404`.

2. **Capa de Lógica (Controllers)**

   * Controladores por dominio: `clientsController`, `productsController`, `invoicesController`, `configController`.
   * Responsables de validar entrada, invocar modelos y devolver vistas o JSON (para AJAX).

3. **Capa de Persistencia (Models)**

   * `mainModel.php` contiene lógica base de DB (conexión PDO y helpers genéricos).
   * Modelos CRUD específicos realizan consultas preparadas, protegen contra inyección SQL y regresan resultados como arrays/objetos.

4. **Capa de Infraestructura / Helpers**

   * Librerías externas (Bootstrap, SweetAlert2, iconos locales), utilidades para PDFs, manejo de archivos (logos), subida de imágenes.

5. **Frontend JS (Ajax.js y otros)**

   * Funciones para enviar peticiones AJAX (POST/GET), manejar respuestas JSON y mostrar alertas con SweetAlert2.
   * Lógica para manipular dinámicamente la tabla de detalles de facturas (añadir filas, calcular totales).

## Flujo de una creación de factura (resumido)

1. Usuario llena formulario de factura y agrega items en la tabla dinámica.
2. JS (Ajax.js) serializa los datos y hace `fetch` / `XMLHttpRequest` al endpoint del controller `InvoicesController::store` (o ruta similar).
3. Controller valida, crea registro en `facturas`, inserta `factura_items` y responde JSON con `status: success` y `id` de la factura.
4. Frontend recibe JSON, limpia la UI (tabla y campos) y muestra SweetAlert2 con mensaje de éxito.


## Reglas y convenciones internas

* Todas las consultas deben usar **PDO** con prepared statements.
* Las rutas amigables pasan parámetros a un front controller que instanciará el controller correspondiente.
* Mantener las vistas lo más libres posible de lógica; delegar cálculos al backend cuando sea crítico.

## Consideraciones para escalado / mejoras

* Migrar a un framework ligero o microframework (Slim, Lumen) para manejar routing y middlewares si el proyecto crece.
* Introducir un ORM (Eloquent o Doctrine) si se aumenta complejidad del modelo de datos.
* Separar `public/` con assets estáticos y un entrypoint `public/index.php` para seguridad.
* Añadir pruebas unitarias para modelos y pruebas funcionales para endpoints críticos.

---

# 3. Guía de Troubleshooting (Problemas frecuentes y solución)

## Cómo usar esta guía

Cuando algo no funciona, ir paso a paso: reproducir, revisar logs, aislar la capa (frontend/backend/DB) y aplicar correcciones.

### 1) Problema: La aplicación no conecta a la base de datos

**Síntomas:** páginas en blanco, errores 500, excepción PDO.

**Verificar:**

* `config/server.php` tiene las constantes correctas (DB_SERVER, DB_NAME, DB_USER, DB_PASSWORD).
* El servicio MySQL está levantado (`sudo service mysql status` / `systemctl status mysql`).
* Las credenciales con las que intentás conectar tienen permisos sobre la base.

**Soluciones comunes:**

* Corregir credenciales en `config/server.php`.
* Si usás sockets unix, ajustar `DB_SERVER` a `127.0.0.1` o la ruta del socket.
* Revisar que la extensión `pdo_mysql` esté habilitada en `php.ini`.

---

### 2) Problema: .htaccess no aplica (URLs amigables no funcionan)

**Síntomas:** error 404 en rutas que deberían mapear a controllers.

**Verificar:**

* Que `mod_rewrite` esté habilitado (`a2enmod rewrite` en Debian/Ubuntu y reiniciar Apache).
* Configuración `AllowOverride` en Apache para que .htaccess sea leído.

**Solución rápida:**

* Habilitar `mod_rewrite` y reiniciar Apache.
* Revisar `DocumentRoot` y que el `.htaccess` esté en la ruta correcta.

---

### 3) Problema: PDF no se genera o da errores

**Síntomas:** excepción al intentar crear PDF, página en blanco o PDF corrupto.

**Verificar:**

* Que la librería PDF (FPDF u otra) esté presente y correctamente incluida.
* Rutas relativas en `require`/`include` estén correctas.
* Permisos para escribir en carpetas temporales (si el PDF se genera antes de descargar).

**Solución:**

* Si instalaste la librería manualmente, verificar `require 'vendor/fpdf/fpdf.php'` o la ruta usada.
* Si usás composer, ejecutar `composer install` y `require 'vendor/autoload.php'` cuando corresponda.
* Probar la creación de un PDF mínimo (script de prueba) para aislar el problema.

---

### 4) Problema: AJAX no notifica o no limpia el formulario (bug reportado en commit 9d442c6)

**Síntomas:** El formulario se envía pero la UI no se actualiza, o la alerta aparece antes de limpiar la tabla.

**Verificar:**

* Revisar `assets/js/Ajax.js` (o la ruta donde esté) y buscar el flujo posterior a `success` en la llamada AJAX.
* Asegurarse que la secuencia sea: 1) actualizar/limpiar DOM (tabla y campos) -> 2) disparar `swal` (SweetAlert) -> 3) opcionalmente redirigir/mostrar enlace al PDF.

**Arreglo comprobado en repo:**

* Se cambió el orden en el método que maneja la respuesta: primero limpiar `table` y `form fields`, luego disparar `SweetAlert2`.

**Si volviera a ocurrir:**

* Abrir consola del navegador (F12) y ver errores JS.
* Añadir `console.log` en callbacks `success`/`then` para verificar datos devueltos.

---

### 5) Problema: Errores JS / SweetAlert2 no muestra nada

**Síntomas:** Al hacer la petición no aparece alerta y/o la consola muestra `Uncaught ReferenceError`.

**Verificar:**

* Que `sweetalert2` esté correctamente incluido antes de `Ajax.js`.
* Que no haya errores de sintaxis en `Ajax.js` (usar linter o abrir la consola del navegador).

**Solución:**

* Revisar el orden de inclusión de scripts: primero dependencias (jQuery si se usa, SweetAlert2), luego `Ajax.js`.

---

### 6) Problema: Permisos / subida de logos o archivos

**Síntomas:** 403 al intentar subir, o archivo no aparece.

**Verificar:**

* Permisos del directorio `uploads/`, `storage/` o donde guardes los logos (permiso de escritura para el usuario del servidor web).
* Límite de tamaño en `php.ini` (`upload_max_filesize`, `post_max_size`).

**Solución:**

* `chown -R www-data:www-data uploads/` (ajustar usuario según SO).
* Aumentar `upload_max_filesize` y `post_max_size` si es necesario y reiniciar PHP-FPM/Apache.

---

### 7) Problema: Render extraño de Bootstrap / iconos faltan

**Síntomas:** Iconos no aparecen o estilos faltantes.

**Verificar:**

* Que los archivos CSS/JS de Bootstrap y los iconos estén en `assets/` y cargados con la ruta correcta.
* Revisar consola (red) para 404 en los assets.

**Solución:**

* Corregir rutas relativas o mover los assets a una carpeta pública accesible.

---

### 8) Logs y debugging general

**Habilitar errores en desarrollo (temporalmente):**

```php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

**Ver logs de Apache/PHP:**

```bash
sudo tail -f /var/log/apache2/error.log
# o para php-fpm
sudo journalctl -u php8.1-fpm -f
```

---

## Contacto y seguimiento

* Para problemas que no resolvás con esta guía: abrir issue en el repositorio con pasos para reproducir, logs (error.log, console) y capturas.

---

# Resumen de commits relevantes (resumen rápido)

* **2025-10-27**: Estructura inicial (MVC + AJAX).
* **Oct 29–Nov 2**: Añadidos modelos, vistas y controladores para clientes y productos; utilidades y assets (Bootstrap, SweetAlert2).
* **Nov 3–Nov 12**: CRUD y vistas para facturas; funciones para creación y edición de facturas.
* **Nov 14**: Implementación de método para crear PDFs con los datos de facturas.
* **Nov 16**: Corrección en `Ajax.js` para notificaciones y limpieza de formulario al registrar datos (fix UX).

---

## Convención de Commits (PowerShell)

```powershell
git commit -m "feat(<área>): Breve descripción del cambio." `
            -m "Por qué: Motivo o necesidad que originó el cambio." `
            -m "Qué: Descripción técnica de lo modificado." `
            -m "Impacto: Consecuencias o beneficios del cambio."
```

🔍 **Ejemplo:**

```powershell
git commit -m "feat(estructura): Cambié la estructura del proyecto a MVC." `
            -m "Por qué: La estructura anterior era desordenada y limitaba nuevas features." `
            -m "Qué: Reorganización completa de carpetas y flujo interno." `
            -m "Impacto: Mayor escalabilidad y facilidad de mantenimiento."
```

> 💡 Nota: Usá **backticks (`)** para continuar comandos en PowerShell.

---

*Fin del documento.*