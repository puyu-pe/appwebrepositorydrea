# Project Overview

## Resumen

Este proyecto es una aplicación web desarrollada en **Laravel 8** para gestionar un **repositorio de evaluaciones educativas**. Su propósito es centralizar evaluaciones, materiales y recursos asociados, permitiendo que los usuarios naveguen por ellos, respondan preguntas, califiquen contenido y dejen testimonios.

Además del portal público, el sistema incluye un **backoffice administrativo** para gestionar catálogos, evaluaciones, usuarios, contactos y respaldos del sistema.

## Objetivo del sistema

El sistema está orientado a publicar y organizar evaluaciones realizadas por entidades educativas, agrupándolas por criterios como:

- tipo de evaluación
- curso
- grado
- año
- dirección o DRE

La plataforma busca facilitar tanto la **consulta pública de evaluaciones** como la **administración interna del contenido**.

## Stack tecnológico

### Backend

- **PHP 7.3 / 8.0**
- **Laravel 8**
- Laravel Sanctum

### Frontend

- Blade
- AdminLTE
- Bootstrap
- jQuery
- Select2
- CKEditor
- SweetAlert
- PNotify

### Infraestructura y build

- MySQL
- Laravel Mix
- Docker / Makefile para entorno local

## Arquitectura funcional

El proyecto está dividido en dos áreas principales:

### 1. Frontoffice

Parte pública del sistema orientada a los usuarios finales.

Incluye:

- página de inicio con acceso al catálogo
- navegación por evaluaciones
- visualización de detalle de evaluación
- registro de respuestas
- calificación de evaluaciones
- testimonios
- formulario de contacto
- autenticación y gestión de perfil

### 2. Backoffice

Parte administrativa orientada a la gestión del contenido y operación del sistema.

Incluye:

- dashboard con métricas
- mantenimiento de catálogos
- administración de evaluaciones y recursos
- administración de usuarios
- gestión de contactos y testimonios
- generación de backups

## Funcionalidades implementadas

### Funcionalidades públicas confirmadas

- **Home pública** con secciones destacadas y acceso al repositorio
- **Exploración de evaluaciones** por filtros y categorías
- **Vista de detalle de evaluación**
- **Previsualización de archivos PDF**
- **Registro de respuestas del usuario**
- **Comparación con respuestas correctas**
- **Sistema de rating o calificación**
- **Registro e inicio de sesión de usuarios**
- **Edición de perfil y recuperación de contraseña**
- **Formulario de contacto**
- **Testimonios de usuarios**

### Funcionalidades administrativas confirmadas

- **Dashboard** con estadísticas generales
- CRUD de **usuarios**
- CRUD de **tipos de examen**
- CRUD de **cursos**
- CRUD de **grados**
- CRUD de **direcciones/DRE**
- CRUD de **evaluaciones**
- CRUD de **recursos**
- gestión de **contactos**
- gestión de **testimonios**
- **backups** de base de datos y archivos

## Estado actual del proyecto

El sistema muestra un nivel de implementación funcional importante, especialmente en su flujo web tradicional con vistas Blade y panel administrativo.

Sin embargo, también se observan algunos puntos de mejora:

- la **API de negocio** es casi inexistente
- los **tests automatizados** son mínimos
- existen indicios de **contenido legacy o placeholder** en algunas vistas
- hay detalles técnicos que conviene revisar, como rutas duplicadas y posibles typos en middleware de permisos

## Madurez técnica observada

### Fortalezas

- estructura Laravel reconocible y funcional
- separación clara entre frontoffice y backoffice
- cobertura amplia de módulos CRUD
- flujo principal del producto ya implementado

### Debilidades

- baja cobertura de pruebas
- poca exposición API
- mantenimiento técnico pendiente en algunos puntos del código
- presencia de valores hardcodeados y restos de interfaz legacy

## Archivos clave del proyecto

- `README.md` — guía básica de instalación
- `composer.json` — dependencias backend
- `package.json` — dependencias frontend y build
- `routes/web.php` — rutas principales del sistema
- `routes/api.php` — superficie API actual
- `app/Http/Controllers/Frontoffice/*` — lógica pública
- `app/Http/Controllers/Backoffice/*` — lógica administrativa
- `resources/views/frontoffice/*` — vistas públicas
- `resources/views/backoffice/*` — vistas administrativas

## Conclusión

El proyecto corresponde a un **repositorio web de evaluaciones educativas** con un alcance funcional ya considerable. La base del producto está implementada y operativa en su enfoque web, aunque todavía necesita mejoras en calidad técnica, cobertura de pruebas y ordenamiento de ciertos detalles para elevar su mantenibilidad.
