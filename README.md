# Rapid Report

An incident reporting platform for health and safety departments.


## Features

- Incident Report Submission
    - Anonymous Option
- Incident Follow Up Submission
    - Investigation
    - Root Cause Analysis
- Incident Status Flow
- Audit Logs
- Notifications
- Admin User Management Dashboard
    - Admin Role
    - Supervisor Role
    - General User Role
- Supporting Document File Uploads
- Excel Data Exports
- Statistical Data Dashboard


## Tech Stack

**Client:**
- [React](https://react.dev/)
- [TypeScript](https://www.typescriptlang.org/)
- [TailwindCSS v4.0](https://tailwindcss.com/)
- [Chart.js](https://www.chartjs.org/)

**Server:**
- [Laravel 12](https://laravel.com/docs/12.x)
- [PHP 8.4](https://www.php.net/releases/8.4/en.php)
- [Inertia](https://inertiajs.com/)
- [Laravel Sail](https://laravel.com/docs/12.x/sail)
- [Laravel Scout](https://laravel.com/docs/12.x/scout)
- [Laravel Excel](https://laravel-excel.com/)
- [Laravel Data](https://spatie.be/docs/laravel-data/v4/introduction)
- [Laravel Event Sourcing](https://spatie.be/docs/laravel-event-sourcing/v7/introduction)
- [Laravel Model States](https://spatie.be/docs/laravel-model-states/v2/01-introduction)
- [Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction)
## Environment Variables

To run this project, you will need to add the following environment variables to your .env file:

- `CACHE_STORE=redis`
- `FILESYSTEM_DISK=s3`

The following environment variables should be updated to the name of the minio bucket that you created:

- `AWS_BUCKET`
- `AWS_URL`

The following environment variables may be optionally updated to your personal credentials **(Note: This option is not recommended as these values will be used during tests which will use resources.)**:

- `VONAGE_KEY=123`
- `VONAGE_SECRET=123`
- `VONAGE_SMS_FROM=19023334444`

## Run Locally

This project has been set up to be compatible with [Laravel Sail](https://laravel.com/docs/12.x/sail), and it is assumed this has been set up as per the Laravel documentation beforehand.

Clone the project

```bash
  git clone git@github.com:OsmiumCoder/rapid-report.git
```

Go to the project directory

```bash
  cd rapid-report
```

Install dependencies

```bash
  npm install
```
```bash
  composer install
```

Copy the example env file and make the required configuration changes in the .env file
```bash
  cp .env.example .env
```

Start Docker containers
```bash
  sail up -d
```

Generate a new application key
```bash
  sail artisan key:generate
```

Run the database migrations (**ensure database rapid_report exists and Docker containers are running**)
```bash
  sail artisan migrate:fresh --seed
```

Start Vite server
```bash
  npm run dev
```

Start Queues *(Optional)*
```bash
  sail artisan queue:work --queue=default,scout
```

You can now access the site at http://localhost

Additionally, the project is utilizing [laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper) and the following custom command can be run *(Optional)*
```bash
 composer generate-typehints
```

## Running Tests

To run tests, run the following command

```bash
  sail test
```

To run linting tests, run the following commands

```bash
  sail pint
```

```bash
  npm run format
```

```bash
  npm run lint
```

## Deployment

Deployment of this project is handled by GitHub Actions. The live server will always point to the `staging` branch of this project.


## Documentation

To view the documentation for this product run:

```bash
  npm run docs:dev
```

## Color Reference

| Color           | Hex                                                              |
|-----------------|------------------------------------------------------------------|
| upei-red-100    | ![#7c2d1c](https://placehold.co/15x15/7c2d1c/7c2d1c.png) #7c2d1c |
| upei-red-200    | ![#8a3d32](https://placehold.co/15x15/8a3d32/8a3d32.png) #8a3d32 |
| upei-red-300    | ![#b84e3e](https://placehold.co/15x15/b84e3e/b84e3e.png) #b84e3e |
| upei-red-400    | ![#9f3a29](https://placehold.co/15x15/9f3a29/9f3a29.png) #9f3a29 |
| upei-red-500    | ![#661702](https://placehold.co/15x15/661702/661702.png) #661702 |
| upei-red-600    | ![#4e0f10](https://placehold.co/15x15/4e0f10/4e0f10.png) #4e0f10 |
| upei-red-700    | ![#3d0c0b](https://placehold.co/15x15/3d0c0b/3d0c0b.png) #3d0c0b |
| upei-red-800    | ![#2b0907](https://placehold.co/15x15/2b0907/2b0907.png) #2b0907 |
| upei-red-900    | ![#1a0604](https://placehold.co/15x15/1a0604/1a0604.png) #1a0604 |
| upei-green-100  | ![#7fa33f](https://placehold.co/15x15/7fa33f/7fa33f.png) #7fa33f |
| upei-green-200  | ![#88b44b](https://placehold.co/15x15/88b44b/88b44b.png) #88b44b |
| upei-green-300  | ![#a3c85f](https://placehold.co/15x15/a3c85f/a3c85f.png) #a3c85f |
| upei-green-400  | ![#7f9d31](https://placehold.co/15x15/7f9d31/7f9d31.png) #7f9d31 |
| upei-green-500  | ![#5c8727](https://placehold.co/15x15/5c8727/5c8727.png) #5c8727 |
| upei-green-600  | ![#4a6e21](https://placehold.co/15x15/4a6e21/4a6e21.png) #4a6e21 |
| upei-green-700  | ![#3b5c1b](https://placehold.co/15x15/3b5c1b/3b5c1b.png) #3b5c1b |
| upei-green-800  | ![#2d4a16](https://placehold.co/15x15/2d4a16/2d4a16.png) #2d4a16 |
| upei-green-900  | ![#1f3912](https://placehold.co/15x15/1f3912/1f3912.png) #1f3912 |
| upei-yellow-100 | ![#fcd177](https://placehold.co/15x15/fcd177/fcd177.png) #fcd177 |
| upei-yellow-200 | ![#fcd95e](https://placehold.co/15x15/fcd95e/fcd95e.png) #fcd95e |
| upei-yellow-300 | ![#fbdb44](https://placehold.co/15x15/fbdb44/fbdb44.png) #fbdb44 |
| upei-yellow-400 | ![#fbbd2d](https://placehold.co/15x15/fbbd2d/fbbd2d.png) #fbbd2d |
| upei-yellow-500 | ![#fbb040](https://placehold.co/15x15/fbb040/fbb040.png) #fbb040 |
| upei-yellow-600 | ![#e69a34](https://placehold.co/15x15/e69a34/e69a34.png) #e69a34 |
| upei-yellow-700 | ![#d2872b](https://placehold.co/15x15/d2872b/d2872b.png) #d2872b |
| upei-yellow-800 | ![#be7322](https://placehold.co/15x15/be7322/be7322.png) #be7322 |
| upei-yellow-900 | ![#a76119](https://placehold.co/15x15/a76119/a76119.png) #a76119 |

## Roadmap

- Introduce PDF exports that are formatted for government submissions
- Utilize websockets for active refreshing


## Authors

- [@osmiumcoder](https://github.com/osmiumcoder) (Jonathon Meney)
- [@welshy557](https://github.com/welshy557) (Liam Welsh)
- [@tinfernn](https://github.com/tinfernn) (Lucas Dunn)
- [@Crounic](https://github.com/Crounic) (Shreif Abdalla)
- [@LCschool](https://github.com/LCschool) (Logan Cheyne)


## Used By

This project is used by the following companies:

- UPEI Health, Safety & Environment Department


## License

This project falls under the [MIT License](https://choosealicense.com/licenses/mit/)

