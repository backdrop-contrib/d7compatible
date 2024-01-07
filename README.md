Drupal 7 Compatible
====================

A base theme that restores Drupal-7-style markup. 

This theme makes it possible to run a Drupal 7 theme on a Backdrop website
without needing to switch all the CSS selectors from IDs to classes.

Some changes may still be necessary, but this should make the task of getting a
Drupal 7 theme to work on  Backdrop site much easier.

Specific changes are noted below.

Page template changes:
- Add back unique classes for each page (`page--node-1234`)
- Add back legacy `front` and `not-front` classes.

Node template changes:
- Restore the legacy node ID as the css ID.
- Restore the legacy `node-teaser` class.
- Add more template suggestions based on view mode.
- Convert `classes` back to a string.
- Convert `attributes` back to a string.
- Convert `content_attributes` back to a string.

Block template changes:
- Restore legacy `block-title` class.
- Restore legacy block ID.
- Add the `navigation` ID to the main menu block in the header (if it is 
  configured to dispay the top menu only).
- Convert `classes` back to a string.
- Convert `attributes` back to a string.
- Convert `title_attributes` back to a string.
- Convert `content_attributes` back to a string.

Field template changes:
- Convert `classes` back to a string.
- Convert `attributes` back to a string.
- Convert `title_attributes` back to a string.
- Convert `content_attributes` back to a string.

Menu markup changes:
- added the ID `main-menu-links` to the UL tag for the main menu.


Installation
------------

- Install this theme using the official Backdrop CMS instructions at
  https://docs.backdropcms.org/documentation/skin-with-themes.

- Add your Drupal 7 theme to your Backdrop site.

- Make the following changes to the info file of your Drupal 7 theme:
  1) add `base theme = d7compatible`
  1) add `backdrop = 1.x`
  1) add `type = theme`

- Make the following changes to the templates of your Drupal 7 theme:
  1) Remove your old `page.tpl.php` file 
    (or rename it to `layout--mytheme.tpl.php` -- you will need it later to 
     create a Layout Template)


<!-- Documentation
-------------

Link to the repository's wiki if more documentation can be found there. Remove
this section if not needed (and consider disabling the wiki in the repo settings
if not used).

Additional documentation is located in the Wiki:
https://github.com/backdrop-contrib/d7compatible/wiki/Documentation.
-->


Issues
------

Bugs and Feature Requests should be reported in the Issue Queue:
https://github.com/backdrop-contrib/d7compatible/issues.


Current Maintainers
-------------------

- [Jen Lampton](https://github.com/jenlampton)
- Seeking additional maintainers


Credits
-------

- Originally written for Backdrop CMS by [Jen Lampton](https://github.com/jenlampton).
- Sponsored by [Strategic Content](https://strategiccontent.com).
- Sponsored by [David Bollier](http://www.wealthofthecommons.org).


License
-------

This project is GPL v2 software.
See the LICENSE.txt file in this directory for complete text.
