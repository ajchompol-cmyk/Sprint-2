# Sprint-2
Sprint 2
# ToCupboard - Sprint 2 (WordPress + API + Pago simulado)
- Accede a la carpeta de los recursos utilizados mediante este enlace
  https://drive.google.com/drive/folders/1oGgxheWVImE03EMRxOzQ-6N15sZVlldZ?usp=drive_link
- Carpeta de sitio web local con xampp
- Certificados autofirmados para sitio HTTPS
## Descripción
Sitio WordPress que consume API de productos y simula pasarela de pagos. Aplicación de prácticas DevSecOps.

## Requisitos
- PHP 7.4+
- MySQL
- WP-CLI (opcional)

## Instalación (local)
1. Clona repo: `git clone https://github.com/tuusuario/tocupboard-sprint2.git`
2. Copia archivos a tu entorno WordPress.
3. Importa DB o sigue pasos de wp-cli.

## Endpoints API
- `GET /wp-json/tocup/v1/products` — Obtener productos (ejemplo externo).
- `POST /wp-json/tocup/v1/order` — Crear orden (requiere X-WP-Nonce).

## Modo prueba Stripe
- Usar llaves test en GitHub Secrets: `STRIPE_TEST_KEY` y `STRIPE_PUBLISHABLE_KEY`

## Cómo probar
1. Abrir `/productos` y verificar listado (shortcode [tc_products]).
2. Realizar checkout con tarjeta test (4242 4242 4242 4242).

## CI / Seguridad
- GitHub Actions ejecuta lint, auditoría y WPScan (staging).
