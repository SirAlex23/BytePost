# BytePost 📰

Blog de noticias tech con agregación automática de noticias e IA.

## Stack
- **Backend**: Laravel 12 + PHP 8.2
- **Base de datos**: MongoDB
- **IA**: Groq (Llama 3)
- **API noticias**: NewsData.io
- **Frontend**: Blade + CSS custom

## Características
- Agregación automática de noticias tech cada 6 horas
- 5 categorías: IA, Ciberseguridad, Tecnología, Dev Tools, Alertas
- Foro de comunidad con hilos y respuestas
- Panel de administración completo
- Sistema de roles: Admin / Editor / Author
- Búsqueda de artículos
- Resúmenes generados por IA

## Instalación
```bash
git clone https://github.com/tuusuario/bytepost
cd bytepost
composer install
cp .env.example .env
php artisan key:generate
# Configura MongoDB, NewsData.io y Groq en .env
php artisan serve
```

## Variables de entorno necesarias
