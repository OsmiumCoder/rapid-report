# Roles and Permissions

Rapid Report has a large number of roles and permissions.

As the roles descend in the hierarchy, the permissions are more restrictive.

### Roles
- admin - all permissions
- supervisor - all permissions of user, permission to follow up, add comments, and upload files
- user - submission of incidents, viewing owned incidents

### Permissions
There are a large number of permissions. Some are more granular than others.

- view all incidents
- view own incidents
- view assigned incidents 
- perform admin actions 
- view reports 
- provide incident follow-up 
- view any incident follow-up 
- manage users 
- add comments 
- download any files 
- download own files

## Back End Integration
Roles and permissions are implemented using the [Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction) package.

The `database/seeders/RolesAndPermissionsSeeder.php` file seeds the roles and permissions as described above.

## Front End Integration
All permissions are automatically passed to the front end via the `app/Http/Middleware/HandleInertiaRequests.php` middleware. They will be placed into the `page.auth.user.roles` object.
