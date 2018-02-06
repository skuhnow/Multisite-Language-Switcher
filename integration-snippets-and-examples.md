---
layout: page
title: Integration, snippets & examples
weight: 4
---

Most people are likely to use the widget provided by the **Multisite Language Switcher**. But the dynamic sidebars are not always the best place for the output of the plugin.


**Please keep in mind: Always backup your files and database prior to work on your site, better safe than sorry.**

> *If you look for explanations of the basic functions, classes and methods of the plugin, then head over  [to this page]({{site.url}}/functions-classes-and-methods).*

## Get the current language ##

You can use the constant _WPLANG_ provided by WordPress if you want to know the language of the current blog. It seems that this constant is empty when the current blog runs in English.

The Multisite Language Switcher sets the language to 'us' in this case. If you want to use this functionality you can write something like that:

```php
$blog     = MslsBlogCollection::instance()->get_current_blog();
$language = $blog->get_language();
```

## Manipulate the Navigation Menu ##

The class _MslsOutput_ comes in handy when you'd like to manipulate the items of a Navigation Menu. First you should check if plugin is active (just check for the existence of function 'the_msls') and if it is the _primary_ menu in your theme (the name can vary). Then you can create the object and request the array of links (in my example just linked flags) to the translations. After that you can create the output, add it to _$items_ and return it.

Here comes a simplified version of the add-on [MslsMenu](https://github.com/lloc/MslsMenu):

```php
function my_custom_menu_item( $items, $args ) {
    if ( function_exists ( 'the_msls' ) && 'primary' == $args->theme_location ) {
        $obj = new MslsOutput;
        $arr = $obj->get( 2 );
        if ( !empty( $arr ) ) {
            $items .= '<li>' . implode( '</li><li>', $arr ) . '</li>';
        }
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'my_custom_menu_item', 10, 2 );
```

You could pass - of course - other values different from _2_. Here is a list with all possibilities:

```php
/* MslsLink - Image + text */
$arr = $obj->get( 0 );
 
/* MslsLinkTextOnly - Just text	*/
$arr = $obj->get( 1 );
 
/* MslsLinkImageOnly - Just image */
$arr = $obj->get( 2 );
 
/* MslsLinkTextImage - Text + image */
$arr = $obj->get( 3 );
```

## Use the blog collection in your functions (and filters) ##

If you want to use the collection of blogs - which created the plugin - in your functions (and filters) you could write code like this:

```php
function my_print_something() {
    foreach ( MslsBlogCollection::instance()->get() as $blog ) {
        printf(
            '<link rel="alternate" hreflang="%1$s" href="http://%1$s.example.com/" />',
            $blog->get_language()
        );
    }
}
add_action( 'wp_head', 'my_print_something' );
```

The above example prints the link references to your blogs in all html headers of the output. This is just a simplified version of what the plugin already does.