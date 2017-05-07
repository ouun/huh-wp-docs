# Who?

_Huh! WP Docs_ was initially dreamt up as _huh_ by the amazing [Dan Hauk](https://danhauk.com/) from [secret pizza party](https://secretpizza.party). After [Silvan Hagen](https://silvanhagen.com) from [required](https://required.com) saw the potential in vastly improved documentation for users of the WordPress admin and the theme customizer, he couldn't help himself and needed to build upon what at first was just _huh_.

One thing that needed to be in _Huh! WP Docs_, was the possibility to add multiple sources for documentation. This was brought to life in a fork from _huh_ by [Daron Spence](http://daronspence.com/). Besides having multiple sources for documentation Silvan wanted more, so _Huh! WP Docs_ was born.

# What?

_Huh! WP Docs_ is a great way to offer in dashboard and in customizer documentation for all your WordPress projects. The content is generated from a markdown files which makes it super quick & easy to update your documentation whenever you want.

The plugin offers filters to add markdown files only to specific pages of the WordPress dashboard from either your theme or another plugin.

# Where?
We think _Huh! WP Docs_ is awesome and we really want you to use it in all your projects. It's totally free/open source and you can find it on [GitHub](https://github.com/neverything/huh-wp-docs/).

## Wanna Contribute? 
If you found a bug, [report it here](https://github.com/neverything/huh-wp-docs/issues/new). If you're a developer, we welcome pull requests of all types!

## Development Workflow
1. Make sure you have `git`, `node`, and `npm` installed and a working WordPress installation.
2. Clone this repository inside your plugin directory.
3. Activate the plugin from the `/wp-admin/` plugins screen and enjoy.

	```
	$ git clone https://github.com/neverything/huh-wp-docs.git
	$ cd huh-wp-docs
	```

4. Watch the front-end CSS/Sass and JS for changes and rebuild accordingly with [Grunt](https://github.com/gruntjs/grunt). Please only modify the Sass files to keep the CSS consistent and clean. Please only modify the `js/src/huh-wp-docs.js` file as this is the base for the compiled and minified version.

	```
	$ npm install
	$ grunt watch
	```

5. Open `/wp-admin/` in your browser.
6. Have fun!


# Why?
[required](https://required.com) is in the process of developing a managed WordPress experience of sorts and while the default plugins and themes we use are quite simple, there is still a need for a wee bit of documentation. External documentation is dumb and everything should be contained in the dashboard. We created _Huh! WP Docs_ to make that happen.

# How? Setup your docs!
Adding _Huh! WP Docs_ to your WordPress installation is incredibly easy.

## Formatting your markdown
_Huh! WP Docs_ pulls all of your `<h1>` tags to use as a table of contents. Each section of your documentation will be contained between these `<h1>` tags. For example:

```
# First section
The content of the first section of your documentation would go here. You can include links, bullets, images, anything!

# Second section
This would be the next section.

## You can even use subheadings
It will all be formatted correctly, but only the first-level headings will show on the table of contents.
```

## Adding your documentation to _Huh! WP Docs_
Once you have your documentation formatted correctly, adding _Huh! WP Docs_ to your WordPress install is simple.

Install the plugin and activate it. If you have `WP_DEBUG` set to true, it will show you what admin screen you are on and have this README.md available for you. From your theme or plugin, use the `huh_wp_docs_filter_doc_urls` filter hook to edit the array of docs.

``` php
function required_super_huh_wp_docs( $doc_urls ) {

	// Unset the all index if you don't want the default README.md file
	unset( $doc_urls['all'] );

	// Use the array index all to show a doc on every screen.
	$doc_urls['all'] = 'https://raw.githubusercontent.com/neverything/huh-wp-docs/master/README.md';
	
	// Use a screen info like the following to add a custom thing.
	$doc_urls['edit.php?post_type=post'] = 'https://raw.githubusercontent.com/neverything/huh-wp-docs/master/README.md';
	
	// Be sure to return the array.
	return $doc_urls;
}
add_filter( 'huh_wp_docs_filter_doc_urls', 'required_super_huh_wp_docs' );
```

Make sure you change the URLs provided in the `$doc_urls` array to point to your markdown files. It's that easy!
