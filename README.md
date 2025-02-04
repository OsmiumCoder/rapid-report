# Rapid Report

An incident reporting platform for health and safety departments.

## Local Setup

### Prerequsites
- [WSL](https://learn.microsoft.com/en-us/windows/wsl/install) (For Windoze users)
- [Docker](https://docs.docker.com/get-started/get-docker/)
- PHP & Extensions: `sudo apt install php php-mbstring php-xml php-zip php-curl php-xdebug`
- [PHP Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/en)

### Installation

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

Paste the following into your shell configuration file (Typically `~/.bashrc`)
```bash
 alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)
```

Restart your shell or enter:
```bash
 source ~/.bashrc
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

Start the server
```bash
  npm run dev
```

You can now access the site at http://localhost (Port 80)

## Running Tests

To run tests, run the following command
```bash
  sail artisan test
```

## Tech Stack

**Client:** [React](https://react.dev/), [Typescript](https://www.typescriptlang.org/), [TailwindCSS](https://tailwindcss.com/)

**Server:** [Laravel](https://laravel.com/)

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

