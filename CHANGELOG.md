## 0.3.6

##### Added
  - Blade Helper widget (helper for using variables feature)
  - ListRenderer interface for showing records lists
  - Search API namespaces support
  - English localization
  - Variables seeders
  - HasState and System model traits
  - Modal delete confirmation
  - Modules suggestions from packagist.org
  - Variables clipboard copy
  - `@trans` blade template with `trans()` javascript helper for translating javascript values
  - Modules dependency system
  - Menu API push method
  - Presets API
  - `defines.php` file for constants
  - Default laravel migrations (users, password_resets)
  - Upload presets file types
  - Upload files extensions validation
  - `--model` and `--request` options for module generator

##### Updated
  - Upload form visuals
  - Installer now run `composer dump-autoload` command
  - Menu reordered
  - Run `composer dump-autoload` after installing module
  - Installer optimizations, now mconsole install/updates faster
  - Filters in modals

##### Fixed
  - Uploads API POST without files error
  - Upload form json errors
  - HasRedirects trait with session errors
  - Modules uninstall migrations errors
  - UserInterface, Pages tests errors
  - Fill `created_at` and `updated_at` fields when creating root user with Installer
  - Clear cache link in settings
  - MconsoleMiddleware routes exceptions

##### Removed
  - Travis CI builds
  - HasFilters, HasPaginator and HasQuery traits

## 0.3.5

##### Added
  - Menu editor
  - Menu seeder
  - Trans partial
  - `trans` javascript helper function
  - `notification` javascript helper function

##### Fixed
  - Tags translations

## 0.3.4

##### Added
  - `Mconsole Middleware` routes exceptions
  - APIs ajax check
  - New Notifications API
  - Dashboard link in menu
  - System menu

##### Fixed
  - Images API get() urlencode
  - Roles routes check
  - Only root user can set user role
  - All users can use search bar
  - Dashboard quotes author

##### Updated
  - Modules sorted by name and installation state
  - APIs controllers moved to `\Http\Controllers\API`
  - Image names display limited to 10 characters
  - Fixed menu bar

## 0.3.3

##### Added
  - Tags editor
  - `HasTags` trait
  - Back button in portlet title

##### Updated
  - Deletion observing on models that using `HasImage` trait

## 0.3.2

##### Added
  - Search bar with an API
  - Settings groups
  - CKEditor

##### Updated
  - Trats renamed
  - Installer `--quick` option to skip long assets copy
  - Translations updater moved from Modules to Settings page

## 0.3.1

##### Added
  - Tags support
  - Copy module public assets to `/public/massets/modules` directory
  - `doctrine/dbal` dependency for migrations

##### Updated
  - `milax/mconsole-base-components` dependency to any version
  - Module generator creates public assets directories

##### Fixed
  - Images API
  - Image model

##### Removed
  - Caching test

## 0.3

##### Added
  - Module service provider support
  - `php artisan make:module --package` option for module packaging including composer.json
  - Detailed modules information
  - `MconsoleOption` seeder API
  - Images API
  - Images Uploader (with inputs and sortable)
  - Some new cool quotes

##### Fixed
  - Empty input values in settings
  - Module install buttons
  - Migrations with `doctrine/dbal` package
  - Empty rows in variables editor

##### Updated
  - Some RU translations
  - Module blueprints
  - Images accessible with public path by symbolic links

## 0.2.4

##### Added
  - Quick menu API
  - Modules extending in modules interface
  - RU translation for modules interface
  - Modules init callbacks
  - Images upload presets builder
  - Settings interface
  - Variables editor interface

##### Fixed
  - Some RU translation strings
  - Modules tests

## 0.2.3

##### Added
  - HasUploads trait for Eloquent models (provides `hasMany Image` relationship)

##### Fixed
  - Pages module tests

## 0.2

##### Added
  - Modular application structure
      - Module loader
      - Module installer
      - Module generator class (`php artisan make:module` to generate custom module in `/app/Mconsole` directory)
  - API
    - Notifications
    - Search
    - Menu
    - Modules
    - Options
    - Quotes (inspiration class)
  - Upload presets section
  - More tests
  - View composer (takes page headings from menu files)
  - File menu loader (including modules)
  - Russian localization
  - Version display in footer
  - "Go to website" button in nav bar
  - Notifications bar
  - Search bar

##### Updated
  - ACL system
  - System font from Open Sans to PT Sans

##### Fixed
  - Date picker component
  - Custom validators
  - Editing `root` user
  - Pages module table multi language heading field

##### Removed
  - All localization files removed, will be localized at 1.0
  - News section removed, available as composer package `milax/mconsole-news`
  - Database menu

## 0.1.2

##### Added
  - Page section
  - News section
  - Date form component with assets
  - Textarea form component
  - MergedMenu class (for merging database + file menu)

##### Updated
  - Database menu is system now, custom menu will be located in `/config/mconsole.php` file

##### Fixed
  - Installer fixed

## 0.1.1

##### Added
  - User roles
  - Blade directive for new Variable model
  - HasRedirects class (trait for controllers)
  - HasFilters class (trait for controllers)
  - HasPaginator class (trait for controllers)

##### Removed
  - CMSController class
  - 50 megabytes of theme assets

## 0.1.0

##### Added
  - Travis CI config
  - PHPUnit tests
  - MconsoleUploadPreset model (for future functional)
  - Status badges in readme
  - MconsoleRole installer with predefined user roles

##### Updated
  - Updated localization

## 0.0.10

##### Added
  - User localization settings
  - Menu localization
  - Menu installation

## 0.0.9

##### Added
  - Users section
  - First Blade directive
  - Localization
  - System template
  - `redirect` method for cms controllers (must have `protected $redirectTo` property)
  - Version display in dashboard
  - Admin creation prompt when installing mconsole

##### Fixed
  - Fixed installer error while seeding database

## 0.0.8

##### Added
  - Package self installer `php artisan mconsole:install`
  - `BladeRenderer` class
  - Models: MconsoleRole, MconsoleMenu, MconsoleUser

##### Updated
  - Models not publishing to app anymore
  - Views moved in `views/mconsole` directory