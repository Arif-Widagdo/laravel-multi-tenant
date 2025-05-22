<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Structures View Engine Multi-Tenant App

```
resources/views/
├── admin/                     # Tampilan untuk super admin/global admin (jika ada)
│   ├── dashboard.blade.php
│   └── users/index.blade.php
│
├── tenant/                   # Semua tampilan untuk tenant application
│   ├── layouts/              # Layout khusus tenant (header, sidebar, dsb)
│   │   └── app.blade.php
│   ├── auth/                 # Autentikasi untuk tenant
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── dashboard.blade.php   # Dashboard tenant
│   ├── profile/              # Profil user tenant
│   │   └── edit.blade.php
│   └── settings/             # Pengaturan tenant (opsional)
│       └── index.blade.php
│
├── shared/                   # Komponen/tampilan umum yang dipakai semua (admin + tenant)
│   ├── components/           # Komponen Blade reusable (alert, modal, dsb)
│   └── layouts/              # Layout utama, jika ada (shared base)
│
├── welcome.blade.php         # Halaman welcome non-tenant (publik)
└── dashboard.blade.php       # Opsional: dashboard global (jika ada)



resources/views/
├── public/                        # Halaman publik / non-login (umum)
│   ├── home.blade.php             # Halaman utama (landing page)
│   ├── about.blade.php
│   └── contact.blade.php
│
├── tenant/                        # Semua tampilan untuk tenant
│   ├── layouts/
│   │   ├── app.blade.php          # Layout utama (untuk authenticated tenant)
│   │   └── guest.blade.php        # Layout guest tenant (login/register)
│   │
│   ├── auth/                      # Untuk login/register tenant
│   │   ├── login.blade.php        # Prefix: /login (middleware: guest)
│   │   └── register.blade.php     # Prefix: /register (middleware: guest)
│   │
│   ├── dashboard/                 # Semua tampilan setelah login tenant
│   │   ├── index.blade.php        # Prefix: /dashboard (middleware: auth)
│   │   └── analytics.blade.php    # Prefix: /dashboard/analytics
│   │
│   ├── profile/                   # Profil user tenant
│   │   └── edit.blade.php         # Prefix: /dashboard/profile (middleware: auth)
│   │
│   └── settings/                  # Pengaturan tenant
│       └── index.blade.php        # Prefix: /dashboard/settings (middleware: auth)
│
├── shared/                        # Komponen/layout yang reusable
│   ├── components/
│   │   ├── alert.blade.php
│   │   └── modal.blade.php
│   └── layouts/
│       └── base.blade.php         # Layout dasar (jika perlu inheritance)
│
└── errors/                        # Error pages
    ├── 404.blade.php
    └── 500.blade.php

```