# Setup

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
