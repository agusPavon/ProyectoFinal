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

## ⚙ Instalación y Configuración


```bash
cd bunaster
Instalar dependencias PHP:
composer install
Instalar dependencias JS:
npm install
Configurar entorno:
cp .env.example .env
php artisan key:generate
Configurar credenciales MySQL y Mapbox en .env.

Migraciones + seeders:
php artisan migrate --seed
Iniciar servidor backend:
php artisan serve
npm run dev