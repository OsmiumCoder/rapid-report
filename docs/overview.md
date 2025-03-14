# Overview

## Main Data Flow
This briefly describes the main data structure of the application.

- [Incident](/modules/incident)
  - has one supervisor (user)
  - has many comments
  - has many files
  - has many investigation
  - has root cause analysis

- [Investigation](/modules/investigation)
  - belongs to an incident
  - belongs to a supervisor (user)

- [RootCauseAnalysis](/modules/purchase-orders)
  - belongs to an incident
  - belongs to a supervisor (user)

- [Comment](/modules/comment)
  - belongs to a user
  - morphs to

- [File](/modules/file)
  - belongs to a user
  - morphs to


## Code Architecture
The code is written the 'Laravel' way.

It is running Laravel 12.x and PHP 8.4. The front end is built using [React 19](https://react.dev) and [Inertia.js](https://inertiajs.com/).

Styles are written in [Tailwind CSS v4](https://tailwindcss.com/).

It is built on top of [Laravel Breeze](https://github.com/laravel/breeze).

[Laravel Sail](https://laravel.com/docs/12.x/sail) is used for [local development](/setup).

[Laravel Scout](https://laravel.com/docs/12.x/scout) is used for searching on incidents.

[Laravel Excel](https://laravel-excel.com/) is used to export data.

[Spatie Laravel Data](https://spatie.be/docs/laravel-data/v4/introduction) is used for form request validation.

[Spatie Laravel Event Sourcing](https://spatie.be/docs/laravel-event-sourcing/v7/introduction) is used for making all aspects of the application event sourced.

[Spatie Laravel Model States](https://spatie.be/docs/laravel-model-states/v2/01-introduction) is used to define a state transition table on Incidents.

[Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction) is used for roles and permissions.

## Permissions
[Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction) - [permissions and roles](/roles-permissions) are handled with laravel permission.

## Deployment
Deployment of this project is handled by GitHub Actions. The live server will always point to the `staging` branch of this project.
