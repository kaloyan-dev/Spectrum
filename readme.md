# Spectrum


Quite basic library for adding admin color schemes to WordPress.

Usage:

`Spectrum::create( {scheme_name}, {base_color}, {highlight_color}, {notification_color}, {action_color} );`

For example:

`Spectrum::create( 'Mystique', '#000', '#4b4c5a', '#b28272', '#c695a6' );`


Just to be save, use on the `after_setup_theme` hook.

Tested up to WordPress 4.4.