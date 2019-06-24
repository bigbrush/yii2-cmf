CMF Change Log
==========================

1.0.10 June 24, 2019
------------------
- Enh: Support of PHP 7.2
- Bug: DeleteButton widget fixed


1.0.9 November 22, 2018
------------------
- Enh: Pages Module: The FileManager widget now loads all media files when used in a modal.


1.0.8 November 22, 2018
------------------
- Enh: Pages Module: The FileManager widget no longer extends past the modal area.


1.0.7 June 6, 2018
------------------
- Bug: Slug (alias) in Page model (page module) is now immutable.


1.0.6 November 16, 2017
------------------
- Bug: UrlRule of pages module now handles url suffixes correctly.


1.0.5 November 08, 2017
------------------
- Enh: BigCms now compatible with AdminLte 2.4.


1.0.4 May 15, 2017
------------------
- Enh: Target attribute allowed on HTML elements.


1.0.3 November 24, 2016
------------------
- Enh: AdminMenu handles the icon properly because root menus does not set one.


1.0.2 November 24, 2016
------------------
- Bug#40: Plugins now handles all response types because it reacts to Response::EVENT_AFTER_PREPARE


1.0.1 October 08, 2016
------------------
- Bug#38: Contact Block now uses the Reponse component instead of the active controller when redirecting.


1.0.0 March 07, 2016
------------------
- Stable release


0.0.5 February XX, 2016
------------------
- Beta version
- Enh: Pages module: A page and category can have up to 6 images attached and displayed as a simple gallery
- Enh: Admin theme handled by Composer.
- Enh: 2 system plugins implemented: "blockinclude" and "youtube".
- Enh: Added "Read more" button to the editor
- Alot of minor fixes and enhancements


0.0.4 June 13, 2015
------------------
- New: Console installation implemented
- New: ACL (access control filter) implemented in Cms default modules (big, pages)
- Upd: Blocks finished (menu, text, pages categories, contact)
- Upd: .htaccess SEO update in frontend and backend


0.0.3 June 03, 2015
------------------
- New: "Scope" added to Cms
- New: Big extension manager integrated
- Upd: Blocks refactored


0.0.2 May 31, 2015
------------------
- New: Console application added
- New: Migrations added
- New: Translations added


0.0.1 May 27, 2015
------------------
- Backend based on Big Framework
- New: Frontend and backend themes
- New: SEO optimized pages
- New: User registration
- New: Widgets
    - Alert (from yii2-advanced template)
    - DeleteButton
    - PopoverButton
    - RadioButtonGroup
- New: Components
    - AdminMenu
    - Toolbar
- New: Blocks
    - Contact
    - Menu
    - Text
