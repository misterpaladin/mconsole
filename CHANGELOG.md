## 0.1.2

Added:
  - Added Page section
  - Added News section
  - Added Date form component with assets
  - Added Textarea form component
  - Added MergedMenu class (for merging database + file menu)

Updated:
  - Database menu is system now, custom menu will be located in `/config/mconsole.php` file

Fixed:
  - Installer fixed

## 0.1.1

Added:
  - Added user roles
  - Added Blade directive for new Variable model
  - Added Redirectable class (trait for controllers)
  - Added Filterable class (trait for controllers)
  - Added Paginatable class (trait for controllers)

Removed:
  - CMSController class
  - 50 megabytes of theme assets

## 0.1.0

Added:
  - Added Travis CI config
  - Added PHPUnit tests
  - Added MconsoleUploadPreset model (for future functional)
  - Added status badges in readme
  - Added MconsoleRole installer with predefined user roles

Updated:
  - Updated localization

## 0.0.10

Added:
  - Added user localization settings
  - Added menu localization
  - Added menu installation

## 0.0.9

Added:
  - Added Users section
  - Added first Blade directive
  - Added localization
  - Added system template
  - Added `redirect` method for cms controllers (must have `protected $redirectTo` property)
  - Added version display in dashboard
  - Added admin creation prompt when installing mconsole

Fixed:
  - Fixed installer error while seeding database

## 0.0.8

Added:
  - Added package self installer `php artisan mconsole:install`
  - Added `BladeRenderer` class
  - Added models: MconsoleRole, MconsoleMenu, MconsoleUser

Updated:
  - Models not publishing to app anymore
  - Views moved in `views/mconsole` directory