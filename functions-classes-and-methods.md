---
layout: page
title: Functions, classes & methods
weight: 3
---

In some cases it can be useful to have the possibility to use the functions and methods of the **Multisite Language Switcher** in a direct way.

**Before you proceed: Backup your files and database prior to trying any of these examples here, better safe than sorry.**

> *If you just look for further examples of how to integrate the plugin or interact with its functionality, then head over  [to this page]({{site.url}}/integration-snippets-and-examples).*

## the\_msls ##

This function can be placed anywhere in your theme-files such as _header.php_, _footer.php_ and _sidebar.php_. It will echo an output similar to the widget.

```php
if ( function_exists ( 'the_msls' ) ) {
    the_msls();
}
```

You can also use some parameters to format the output to suit your needs.

```php
if ( function_exists ( 'the_msls' ) ) {
    $args = array(
        'before_item'   => '<li>',
        'after_item'    => '</li>',
        'before_output' => '<ul>',
        'after_output'  => '</ul>',
    );
    the_msls( $args );
}
```

*This would create the output formatted in an unordered list.*

## get\_the\_msls ##

Use this function if a string is needed because your theme handles the output in a different way, for example.

```php
$str = '';
if ( function_exists ( 'get_the_msls' ) ) {
    $str = get_the_msls();
}
```

**get\_the\_msls** accepts the same parameters as **the\_msls**.

## MslsOutput ##

All these functions use an object type of __MslsOutput__. The magic method '\_\_toString' handles all needs when this object is printed. But you can use the 'get'-method directly if you want to work - for example - with the returning array of links before it is converted:

```php
$object  = new MslsOutput();
$display = 0;
$exists  = false;

foreach ( $object->get( $display, $exists ) as $link ) {
    echo $link;
}
```

The parameter _$display_ is an integer which can contain any number from 0 to 4. There is a static method in the class *MslsLink* which is used in a similar way in the option-page of the plugin:

`print_r( MslsLink::get_types() );`

If you want to show links to existing translations only set the parameter _$exists_ to _true_.