# Wordpress User Fetcher Plugin  

*This project is a showcase product and may be used for eductional purpose.*

## What can it do?

On activation this pluging will create a new Page in your current wordpress. This page has by default the name **Users Table** and will available at  *yourdomain.com/ras-user-fetcher*. In the case you have the Permalink settings in "Plain" mode you will need to navigate there by your websites navigation or wordpress admin. the following functionalities will work the same.

When you open the page for the first time it will load a Users list via ajax and builds a table to display its information. You can click either on the user id, the name or the username and a new table will appear on top. In this table you get more detailed information as email, website, address and 3 button. The button will load this users albums, posts or todos and shows them in a new table rigth below. If there is an error in any of these steps a Error pop-up will show a according Error message.
You will recognize that the first load of the page or a user details can take quite long, we have to wait for the external Api to reply. Since the plugin implements caching are all following loads of the same data nearly instand ready.


On deactivation the plugin does the cleanup and deletes the previous crated Users Table page.

## Requirements
- php:  *>7.2*
- composer installed
- jQuery activated


## Scripts

This plugin comes with batteries included:

Install dependendies

```bash
composer install
```

Run Tests

```bash
composer test
```

Lint

```bash
composer lint
```

Run linting with auto-fix

```bash
composer lint:fix
```

## A deeper look under the hood

### Configuration

#### With config.local.php
*the config.local.php file is part of gitignore, so adding this file will not result in version control issues*

```php
$config = [
    	'Caching Time' => 3600,
    	'Endpoint' => 'ras-user-fetcher',
    	'Fetch Url' => 'https://jsonplaceholder.typicode.com/users',
    	'Page Title' => 'Users Table',
	];

if (file_exists('config.local.php')) {
    include 'config.local.php';
}
```

As seen in `config.php` are you able to configure the plugin by providing a `config.local.php` file.
To change the title of the page and lower the fetch cache to 1 minute, you could do

```php
	$config['Page Title'] = 'My new shiny title';
	$config['Caching Time'] = 60;
``` 

#### Configuring class Instances

If you are working direct with the plugin classes, you can do any configuration freely with help of the according *setter methods*

```php
	$Activator =  new new Rasta\UserFetcher\Activator();
	$Activator->setEndpoint("new-end-point")->setPageTitle("New Page Title")->setSnippet("<div></div>")->setHandler("Rasta\UserFetcher");	

``` 

or with a custom construction

```php
	$Activator =  new Rasta\UserFetcher\Activator("new-end-point", "New Page Title", "<div></div>","Rasta\UserFetcher");

``` 

### Styling

*Does it look ugly?*

This plugin does not provide any kind of styling or template manipulations. The underlaying idea is that the plugin can integrates into any existing theme without interfering with existing color schems, styles or customizations.  **Styles belong into a theme** 

### JavaScript

This plugin includes 3 different JavaScript files. `jquery-ui.min.js` and `jquery.jtable.min.js` are the used library files, while `ras-user-fetcher.min.js` configures jTable instance to our needs. See `ras-user-fetcher.js` for the non-minified development version of `ras-user-fetcher.min.js`

### Why jTable jQuery extension?

Even though jQuery is left behind in the modern JavaScript world, so is it still a useful tool. It comes by default with a wordpress installation and has a heap of useful extensions as here with *jTable*. *JTable* does the job for our requirements without much trouble just by providing a configuration for the needed tables and elements to attach them to. I just configured the *MVP* but it could be extended easily for the most common needs. This is not intended as a showcase of modern JavaScript development, rather then using a fitting tool.

### Why use a page as endpoint?

The activation process creates a page, attaches a html-element as root for *jTable*  to its content and includes the needed js files to start the app.
We could use a hook based implementation instead and render the app without a *page* object. I tried both and I think that the option to interact with the object in the normal wp context is quite a benefit. As a user it shows in my menues, I can edit the title and even add content above or below the displayed table with my standard tools.












