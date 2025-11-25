# ☕ Bunaster – Plataforma de Cafés de Especialidad

Bunaster es una aplicación web orientada a conectar a la comunidad del café de especialidad. Permite explorar cafeterías, dejar reseñas, hacer check-ins, sumar puntos (Beans), subir de nivel, ganar badges y suscribirse a la Bunaster Box mensual.

---

## 🚀 Funcionalidades Principales

### 🗺 Exploración de Cafeterías
- Mapa interactivo con *Leaflet.js* y *Mapbox*
- Marcadores dinámicos con información del café
- Modal con descripción, rating y acciones
- Buscador inteligente con autocompletado

### ✍ Reseñas
- Calificación por estrellas
- Selección de atributos (single origin, leches, ambiente)
- Comentarios personalizados
- Prevención de reseñas duplicadas

### 📍 Check-ins
- Foto opcional y comentario
- Registro de ubicación (lat/lng)
- Suma de Beans automáticamente

### 🫘 Sistema de Beans + Niveles
- Beans acumulados por acciones
- Badges según required_beans
- Barra circular de progreso
- Timeline visual con historial de puntos
- Modal de subida de nivel (con confetti)

### 📬 Sugerencias de Cafeterías
- Autocomplete con *Mapbox Geocoding*
- Marcador arrastrable
- Guarda sugerencias como "pendiente"
- Panel admin para ver, aprobar o rechazar

### 📦 Suscripción Bunaster Box
- 3 planes disponibles: Starter, Barista y Master Brewer
- Vista moderna y responsive
- Preparado para integración con Mercado Pago

---

## 🛠 Tecnologías Utilizadas

- Laravel 12  
- Blade Templates  
- TailwindCSS  
- MySQL  
- JavaScript (ES6)  
- Leaflet.js + Mapbox  
- Vite  
- canvas-confetti  

---





## 🚀 Instalación de Bunaster en otra PC (Guía rápida)
### 1️⃣ Instalar Laragon

Descargar Laragon desde: https://laragon.org/download/

Instalar Laragon (versión Full recomendada).

Abrir Laragon → presionar “Start All” para iniciar Apache + MySQL.

### 2️⃣ Clonar o copiar el proyecto

En la carpeta de proyectos de Laragon:

C:\laragon\www\


Cloná o copiá tu proyecto:

git clone https://github.com/agusPavon/ProyectoFinal

### 3️⃣ Instalar dependencias de PHP

Abrí una terminal dentro del proyecto:

cd C:\laragon\www\bunaster


Instalá dependencias:

composer install

### 4️⃣ Instalar dependencias de Node
npm install
npm run build


(O en desarrollo podés usar: npm run dev)

### 5️⃣ Crear archivo .env

Copiar el ejemplo:

cp .env.example .env


Generar la key:

php artisan key:generate

### 6️⃣ Importar la base de datos
Dentro de Laragon:

Abrir Menu → MySQL → phpMyAdmin

Crear una base de datos llamada:

bunaster


Importar el archivo SQL:

Ir a Importar

Seleccionar tu archivo:

/database/sql/bunaster.sql


⚠️ Importante:
Si da error "Failed to open referenced table 'users'", primero importar users (si está separado) o desactivar checks:

Antes de importar:

SET FOREIGN_KEY_CHECKS = 0;


Después:

SET FOREIGN_KEY_CHECKS = 1;

### 7️⃣ Configurar .env con tu DB

Editar:

DB_DATABASE=bunaster
DB_USERNAME=root
DB_PASSWORD=


(Si Laragon usa contraseña, agregarla)

### 8️⃣ Configurar almacenamiento

Laravel necesita el link simbólico:

php artisan storage:link


Esto permite cargar imágenes de check-ins, avatares, etc.

### 9️⃣ Iniciar servidor
php artisan serve


La app queda disponible en:

http://127.0.0.1:8000
