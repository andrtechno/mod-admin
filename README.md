mod-admin
===========
Module for CORNER CMS

[![Latest Stable Version](https://poser.pugx.org/panix/mod-admin/v/stable)](https://packagist.org/packages/panix/mod-admin) [![Total Downloads](https://poser.pugx.org/panix/mod-admin/downloads)](https://packagist.org/packages/panix/mod-admin) [![Monthly Downloads](https://poser.pugx.org/panix/mod-admin/d/monthly)](https://packagist.org/packages/panix/mod-admin) [![Daily Downloads](https://poser.pugx.org/panix/mod-admin/d/daily)](https://packagist.org/packages/panix/mod-admin) [![Latest Unstable Version](https://poser.pugx.org/panix/mod-admin/v/unstable)](https://packagist.org/packages/panix/mod-admin) [![License](https://poser.pugx.org/panix/mod-admin/license)](https://packagist.org/packages/panix/mod-admin)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist panix/mod-admin "*"
```

or add

```
"panix/mod-admin": "*"
```

to the require section of your `composer.json` file.

Add to web config.
```
'modules' => [
    'admin' => ['class' => 'panix\mod\admin\Module'],
],
```