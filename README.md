# Sistema de Gestión de Alumnos y Notas

Sistema web desarrollado en PHP para la gestión de alumnos y sus calificaciones, con generación de reportes en Excel y PDF.

## 📋 Características

- ✅ **CRUD Completo de Alumnos**: Crear, leer, actualizar y eliminar alumnos
- ✅ **CRUD Completo de Notas**: Gestión completa de calificaciones (0-10)
- ✅ **Cálculo Automático de Promedios**: Promedio con 2 decimales
- ✅ **Calificación Cualitativa**: Suspenso, Bien, Notable, Sobresaliente
- ✅ **Reportes Excel**: Exportación profesional con PhpSpreadsheet
- ✅ **Reportes PDF**: Generación de PDF con TCPDF
- ✅ **Interfaz Moderna**: Bootstrap 5.3.8 con diseño responsive
- ✅ **Seguridad**: PDO con prepared statements (prevención SQL Injection)
- ✅ **Arquitectura MVC**: Código organizado y escalable
- ✅ **Validación en Tiempo Real**: JavaScript para validación instantánea

## 🎯 Requisitos del Sistema

### Requisitos Obligatorios
- **PHP**: >= 7.4 con extensión `ext-zip` habilitada
- **MySQL**: >= 5.7
- **Servidor Web**: Apache (XAMPP recomendado)

### Requisitos Opcionales (Solo para Reportes)
- **Composer**: Para instalar PhpSpreadsheet y TCPDF

> **Nota**: La aplicación funciona completamente **sin Composer**. Solo necesita Composer si desea generar reportes Excel y PDF.

## 📦 Instalación Rápida

### Paso 1: Verificar XAMPP

Asegúrese de que **Apache** y **MySQL** estén ejecutándose en el Panel de Control de XAMPP.

### Paso 2: Colocar el Proyecto

Coloque el proyecto en la carpeta de su servidor web:
```
c:\xampp\htdocs\php\gestion_alumnos\
```

### Paso 3: Importar Base de Datos

1. Abra phpMyAdmin: `http://localhost/phpmyadmin`
2. Cree una nueva base de datos llamada `gestion_alumnos`
3. Importe el archivo `gestion_alumnos.sql` desde la raíz del proyecto

### Paso 4: Habilitar Extensión ZIP de PHP

**IMPORTANTE**: PhpSpreadsheet requiere la extensión ZIP de PHP.

1. Abra el archivo `C:\xampp\php\php.ini` en un editor de texto
2. Busque la línea `;extension=zip`
3. Quite el punto y coma para dejarla como: `extension=zip`
4. Guarde el archivo
5. **Reinicie Apache** en XAMPP

### Paso 5: Acceder a la Aplicación

Abra su navegador y visite:
```
http://localhost/php/gestion_alumnos/public/index.php
```

**¡La aplicación ya está funcionando!** 🎉

---

## 📦 Instalación de Composer (Opcional - Para Reportes)

Si desea usar la funcionalidad de reportes Excel y PDF, necesita instalar Composer y las dependencias.

### Opción 1: Instalar Composer Globalmente (Recomendado)

1. **Descargar Composer**:
   - Visite: https://getcomposer.org/download/
   - Descargue `Composer-Setup.exe` para Windows

2. **Instalar Composer**:
   - Ejecute el instalador
   - Siga las instrucciones del asistente
   - El instalador detectará automáticamente PHP de XAMPP

3. **Verificar Instalación**:
   ```powershell
   composer --version
   ```

4. **Instalar Dependencias del Proyecto**:
   ```powershell
   cd c:\xampp\htdocs\php\gestion_alumnos
   composer install
   ```

### Opción 2: Usar composer.phar Directamente

Si no desea instalar Composer globalmente:

1. **Descargar composer.phar**:
   - Visite: https://getcomposer.org/download/
   - Descargue `composer.phar`
   - Colóquelo en `c:\xampp\htdocs\php\gestion_alumnos\`

2. **Ejecutar con PHP de XAMPP**:
   ```powershell
   cd c:\xampp\htdocs\php\gestion_alumnos
   C:\xampp\php\php.exe composer.phar install
   ```

### Resultado Esperado

Después de ejecutar `composer install`, verá:
```
Loading composer repositories with package information
Installing dependencies...
  - Installing phpoffice/phpspreadsheet (...)
  - Installing tecnickcom/tcpdf (...)
Generating autoload files
```

Se creará la carpeta `/vendor/` con todas las librerías necesarias.

---

## 📁 Estructura del Proyecto

```
gestion_alumnos/
├── config/                      # Configuración
│   ├── database.php            # Conexión PDO
│   └── constants.php           # Constantes del sistema
├── src/
│   ├── models/                 # Modelos de datos
│   │   ├── Alumno.php
│   │   └── Nota.php
│   ├── controllers/            # Controladores
│   │   ├── AlumnoController.php
│   │   ├── NotaController.php
│   │   └── ReporteController.php
│   └── views/                  # Vistas
│       ├── layouts/            # Plantillas comunes
│       ├── alumnos/            # Vistas de alumnos
│       ├── notas/              # Vistas de notas
│       └── reportes/           # Vistas de reportes
├── public/                     # Archivos públicos
│   ├── assets/
│   │   ├── css/custom.css
│   │   └── js/main.js
│   ├── vendor/bootstrap-5.3.8-dist/
│   ├── index.php               # Página principal (Dashboard)
│   ├── alumnos.php             # Router alumnos
│   ├── notas.php               # Router notas
│   └── reportes.php            # Router reportes
├── vendor/                     # Dependencias Composer (generado)
├── composer.json               # Configuración Composer
├── gestion_alumnos.sql        # Script de base de datos
└── README.md                   # Este archivo
```

## 🎨 Escala de Calificación

| Rango | Resultado | Badge |
|-------|-----------|-------|
| 0 - 4.99 | Suspenso | 🔴 Rojo |
| 5 - 6.99 | Bien | 🔵 Azul |
| 7 - 8.99 | Notable | 🟣 Morado |
| 9 - 10 | Sobresaliente | 🟢 Verde |

## 📊 Uso del Sistema

### Dashboard (Página Principal)

El dashboard muestra:
- Total de alumnos registrados
- Total de notas registradas
- Promedio general del sistema
- Accesos rápidos a todas las secciones

### Gestión de Alumnos

1. **Crear Alumno**: 
   - Click en "Nuevo Alumno" o "Ver Alumnos" → "Nuevo Alumno"
   - Completar: Nombre, Apellido, Correo Electrónico
   - Click en "Guardar"

2. **Editar Alumno**: 
   - En la tabla de alumnos, click en el botón de editar (✏️ lápiz)
   - Modificar los datos necesarios
   - Click en "Guardar"

3. **Eliminar Alumno**: 
   - Click en el botón de eliminar (🗑️ papelera)
   - Confirmar la eliminación
   - **Nota**: Se eliminarán también todas las notas asociadas

### Gestión de Notas

1. **Registrar Nota**: 
   - Click en "Nueva Nota" en el menú de Notas
   - Seleccionar alumno del dropdown
   - Ingresar nota (0-10, acepta decimales)
   - Click en "Guardar"

2. **Ver Notas por Alumno**: 
   - En la sección "Notas", cada alumno aparece en una tarjeta
   - Muestra todas sus notas individuales
   - Muestra el promedio y resultado cualitativo

3. **Editar Nota**: 
   - En la tarjeta del alumno, click en el botón de editar (✏️) de la nota específica
   - Modificar el valor
   - Click en "Guardar"

4. **Eliminar Nota**: 
   - Click en el botón de eliminar (🗑️) de la nota específica
   - Confirmar la eliminación

### Generar Reportes

> **Requiere Composer instalado**

1. **Reporte Excel**: 
   - Ir a la sección "Reportes"
   - Click en "Descargar Excel"
   - Se descarga archivo `.xlsx` con formato profesional

2. **Reporte PDF**: 
   - Ir a la sección "Reportes"
   - Click en "Descargar PDF"
   - Se descarga archivo `.pdf` con formato profesional

**Contenido de los Reportes**:
- Listado completo de alumnos
- Todas las notas por alumno
- Promedios calculados
- Resultados cualitativos con colores
- Fecha de generación

## 🔒 Seguridad

- ✅ **PDO con Prepared Statements**: Prevención de SQL Injection
- ✅ **Validación de Datos**: Validación en servidor (PHP) y cliente (JavaScript)
- ✅ **Sanitización de Salida**: `htmlspecialchars()` en todas las salidas
- ✅ **Validación de Email**: `filter_var()` con `FILTER_VALIDATE_EMAIL`
- ✅ **Validación de Rangos**: Notas entre 0 y 10
- ✅ **Validación en Tiempo Real**: JavaScript previene errores antes de enviar
- ✅ **Confirmación de Eliminación**: Diálogos de confirmación para acciones destructivas

## 🛠️ Tecnologías Utilizadas

- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL con PDO
- **Frontend**: HTML5, CSS3, JavaScript ES6+
- **Framework CSS**: Bootstrap 5.3.8
- **Iconos**: Bootstrap Icons
- **Excel**: PhpSpreadsheet ^1.29
- **PDF**: TCPDF ^6.6
- **Arquitectura**: MVC Ligero

## 🐛 Solución de Problemas

### Error: "PhpSpreadsheet no está instalado"

**Causa**: Las dependencias de Composer no están instaladas.

**Solución**:
```powershell
cd c:\xampp\htdocs\php\gestion_alumnos
composer install
```

### Error: "ext-zip is missing from your system"

**Causa**: La extensión ZIP de PHP no está habilitada.

**Solución**:
1. Abra `C:\xampp\php\php.ini`
2. Busque `;extension=zip`
3. Quite el `;` para dejar: `extension=zip`
4. Guarde y **reinicie Apache** en XAMPP

### Error de Conexión a Base de Datos

**Posibles causas y soluciones**:

1. **MySQL no está activo**:
   - Verifique que MySQL esté ejecutándose en XAMPP

2. **Credenciales incorrectas**:
   - Verifique `config/database.php`:
   ```php
   private $host = "localhost";
   private $username = "root";
   private $password = "";
   private $database = "gestion_alumnos";
   ```

3. **Base de datos no existe**:
   - Asegúrese de haber importado `gestion_alumnos.sql` en phpMyAdmin

### Páginas sin Estilos (CSS)

**Causa**: Ruta incorrecta en `config/constants.php`

**Solución**:
Verifique que la ruta sea correcta según su instalación:
```php
define('BASE_URL', '/php/gestion_alumnos/public');
```

Si instaló en otra ubicación, ajuste la ruta:
```php
// Ejemplo: si está en c:\xampp\htdocs\gestion_alumnos
define('BASE_URL', '/gestion_alumnos/public');
```

### Mensajes de Error Duplicados

**Causa**: Caché del navegador con código antiguo.

**Solución**:
Presione `Ctrl + F5` para forzar la recarga y limpiar el caché del navegador.

### Error: "composer no se reconoce como comando"

**Causa**: Composer no está instalado globalmente o no está en el PATH.

**Soluciones**:
1. Instale Composer globalmente (ver sección de instalación arriba)
2. O use `composer.phar` directamente con PHP de XAMPP

### Error: "php no se reconoce como comando"

**Causa**: PHP no está en el PATH del sistema.

**Solución**:
1. Presione `Win + R`, escriba `sysdm.cpl` y presione Enter
2. Vaya a "Opciones avanzadas" → "Variables de entorno"
3. En "Variables del sistema", busque "Path" y haga click en "Editar"
4. Click en "Nuevo" y agregue: `C:\xampp\php`
5. Click en "Aceptar" en todas las ventanas
6. **Reinicie PowerShell**

## ✅ Funcionalidades Disponibles

### Sin Composer (Funcionalidades Básicas)
- ✅ Dashboard con estadísticas
- ✅ Ver, crear, editar y eliminar alumnos
- ✅ Ver, crear, editar y eliminar notas
- ✅ Cálculo automático de promedios
- ✅ Resultados cualitativos con colores
- ✅ Validación en tiempo real
- ❌ Reportes Excel
- ❌ Reportes PDF

### Con Composer (Funcionalidades Completas)
- ✅ Todas las funcionalidades básicas
- ✅ Reportes Excel profesionales
- ✅ Reportes PDF profesionales

## 📝 Configuración Avanzada

### Cambiar Credenciales de Base de Datos

Edite `config/database.php`:
```php
private $host = "localhost";        // Servidor MySQL
private $username = "root";         // Usuario MySQL
private $password = "";             // Contraseña MySQL
private $database = "gestion_alumnos"; // Nombre de la BD
```

### Cambiar Escala de Calificación

Edite `config/constants.php`:
```php
define('NOTA_MIN', 0);
define('NOTA_MAX', 10);
define('RANGO_SUSPENSO', 4.99);
define('RANGO_BIEN', 6.99);
define('RANGO_NOTABLE', 8.99);
define('RANGO_SOBRESALIENTE', 10);
```

### Personalizar Mensajes del Sistema

Edite `config/constants.php`:
```php
define('MSG_ALUMNO_CREADO', 'Alumno registrado exitosamente.');
define('MSG_NOTA_CREADA', 'Nota registrada exitosamente.');
// ... otros mensajes
```

## 📞 Resumen de Instalación

1. ✅ **Instalar XAMPP** y activar Apache + MySQL
2. ✅ **Importar** `gestion_alumnos.sql` en phpMyAdmin
3. ✅ **Habilitar** extensión ZIP en `php.ini`
4. ✅ **Reiniciar** Apache en XAMPP
5. ✅ **Acceder** a `http://localhost/php/gestion_alumnos/public/index.php`
6. ⚠️ **Opcional**: Instalar Composer y ejecutar `composer install` para reportes

## 👨‍💻 Desarrollo

### Notas Técnicas
- El sistema usa sesiones PHP para mensajes flash
- Los reportes se generan en tiempo real (no se almacenan)
- La arquitectura MVC permite fácil escalabilidad
- Todos los formularios tienen validación HTML5, JavaScript y PHP
- La base de datos usa `utf8mb4_unicode_ci` para soporte completo de caracteres

### Próximas Mejoras Sugeridas
- Sistema de autenticación de usuarios
- Roles y permisos
- Historial de cambios
- Gráficos de rendimiento
- API REST para integración con otras aplicaciones

## 📄 Licencia

Este proyecto es de código abierto y está disponible para uso educativo.

---

