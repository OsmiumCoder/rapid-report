# Rapid Report

An incident reporting platform for health and safety departments.

## Run Locally

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
  composer install
```
```bash
  npm install
```

Copy the example env file and make the required configuration changes in the .env file
```bash
  cp .env.example .env
```

Generate a new application key
```bash
  php artisan key:generate
```

Run the database migrations (**ensure database rapid_report exists and Laragon is running**)
```bash
  php artisan migrate:fresh --seed
```

Start the server
```bash
  npm run rev
```

You can now access the site at http://rapid-report.test

## Running Tests

To run tests, run the following command
```bash
  php artisan test
```

## Tech Stack

**Client:** React, TailwindCSS

**Server:** Laravel

## License
TBD

## Documentation
WIP

## Authors

- [@osmiumcoder](https://github.com/osmiumcoder) (Jonathon Meney)
- [@Crounic](https://github.com/Crounic) (Shreif Abdalla)
- [@welshy557](https://github.com/welshy557) (Liam Welsh)
- [@LCschool](https://github.com/LCschool) (Logan Cheyne)
- [@tinfernn](https://github.com/tinfernn) (Lucas Dunn)

## Used By

This project is used by the following companies:
- UPEI Health & Safety Department

