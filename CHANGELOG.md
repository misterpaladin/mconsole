## 0.2

Added:
  - Modular application structure
  - Module loader class
  - Module generator class (`php artisan make:module` to generate custom module in `/app/Mconsole` directory)
  - Upload presets section
  - More tests
  - View composer (takes page headings from database menu)

Fixed:
  - Date picker component
  - Custom validators

Removed:
  - All localization files removed, will be localized at 1.0
  - News section removed, available as composer package `milax/mconsole-news`

## 0.1.2

Added:
  - Page section
  - News section
  - Date form component with assets
  - Textarea form component
  - MergedMenu class (for merging database + file menu)

Updated:
  - Database menu is system now, custom menu will be located in `/config/mconsole.php` file

Fixed:
  - Installer fixed

## 0.1.1

Added:
  - User roles
  - Blade directive for new Variable model
  - Redirectable class (trait for controllers)
  - Filterable class (trait for controllers)
  - Paginatable class (trait for controllers)

Removed:
  - CMSController class
  - 50 megabytes of theme assets

## 0.1.0

Added:
  - Travis CI config
  - PHPUnit tests
  - MconsoleUploadPreset model (for future functional)
  - Status badges in readme
  - MconsoleRole installer with predefined user roles

Updated:
  - Updated localization

## 0.0.10

Added:
  - User localization settings
  - Menu localization
  - Menu installation

## 0.0.9

Added:
  - Users section
  - First Blade directive
  - Localization
  - System template
  - `redirect` method for cms controllers (must have `protected $redirectTo` property)
  - Version display in dashboard
  - Admin creation prompt when installing mconsole

Fixed:
  - Fixed installer error while seeding database

## 0.0.8

Added:
  - Package self installer `php artisan mconsole:install`
  - `BladeRenderer` class
  - Models: MconsoleRole, MconsoleMenu, MconsoleUser

Updated:
  - Models not publishing to app anymore
  - Views moved in `views/mconsole` directory