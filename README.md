# StudioKit

StudioKit is a Laravel-based SaaS for creating and managing branding kits on shared hosting.

## Architecture Overview
- **Laravel 10** app (Blade views, Form Requests, Policies).
- **Multi-tenant workspaces** with role-based access.
- **Stripe billing** using Checkout + Customer Portal + webhooks.
- **Exports** via dompdf (PDF) + ZipArchive (ZIP) + Intervention Image (templates).
- **Storage** uses local disk by default with optional S3.

## Route Map
**Marketing**
- `GET /` landing
- `GET /pricing` pricing
- `GET /faq` FAQ

**Auth**
- `GET /register`, `POST /register`
- `GET /login`, `POST /login`
- `POST /logout`
- `GET /forgot-password`, `POST /forgot-password`
- `GET /reset-password/{token}`, `POST /reset-password`

**Installer**
- `GET /install`, `POST /install`

**App** (`/app`)
- `GET /app` dashboard
- `GET /app/kits/create`, `POST /app/kits`
- `GET /app/kits/{kit}`, `PUT /app/kits/{kit}`, `DELETE /app/kits/{kit}`
- `POST /app/kits/{kit}/assets`, `DELETE /app/kits/{kit}/assets/{asset}`
- `POST /app/kits/{kit}/colors`, `DELETE /app/kits/{kit}/colors/{color}`
- `PUT /app/kits/{kit}/fonts`
- `GET /app/kits/{kit}/export` (PDF)
- `GET /app/kits/{kit}/export/zip` (ZIP)
- `POST /app/kits/{kit}/templates`
- `GET /app/kits/{kit}/share`, `POST /app/kits/{kit}/share`, `PUT /app/kits/{kit}/share/{link}`
- `GET /app/workspace/members`, `POST /app/workspace/invites`
- `GET /app/settings`, `PUT /app/settings`
- `GET /app/billing`, `POST /app/billing/checkout/{plan}`, `POST /app/billing/portal`

**Public share**
- `GET /share/{token}`
- `GET /share/{token}/zip`

**Stripe webhook**
- `POST /stripe/webhook`

## Database Schema (Migrations)
- `users`
- `workspaces`
- `workspace_members`
- `brand_kits`
- `brand_assets`
- `colors`
- `font_selections`
- `template_assets`
- `share_links`
- `invites`
- `subscriptions`

## cPanel Setup Guide
1. **Upload files**
   - Download the **pre-built release bundle** from GitHub (includes `vendor/`).
   - Upload the full bundle to your hosting account.
   - Set the document root to the `/public` directory.
2. **No Composer required**
   - The installer requires `vendor/` to exist. The release bundle already includes it.
   - If you build from source, run `composer install --no-dev --optimize-autoloader` locally and upload the generated `vendor/` directory.
3. **Create the database**
   - Create a MySQL/MariaDB database and user in cPanel **or** check “Create database” in the installer (requires privileges).
4. **Configure `.env`**
   - Copy `.env.example` to `.env` and update values, or use the installer at `/install`.
5. **Run migrations**
   - Either use the installer or run `php artisan migrate --force`.
6. **Storage**
   - Ensure `storage/` and `bootstrap/cache/` are writable.
7. **Email**
   - Configure SMTP values in `.env` (cPanel SMTP or Resend via SMTP).
8. **Stripe**
   - Add Stripe keys and price IDs in `.env`.
   - Configure the webhook endpoint `/stripe/webhook` in your Stripe dashboard.
9. **Cron (optional)**
   - Add a cron job: `* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1`

## Demo Data
Seed a demo workspace and kit with:
```
php artisan db:seed
```

## Tailwind Build
Tailwind is compiled at build time. Rebuild assets with:
```
npm install
npm run build
```

## Release Bundle (prebuilt)
To create a prebuilt ZIP that includes `vendor/` (so no Composer is required on the server):
```
./scripts/build-release.sh
```
Upload the generated `dist/studiokit-release.zip` contents to your hosting account.
