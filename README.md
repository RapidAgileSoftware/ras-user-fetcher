# Wordpress Demo Plugin

*This project is a showcase product and may be used for eductional purpose.*

## What can it do?

On activation this plugin will create a new Page in your current wordpress. This page has by default the name **Users Table** and will be available at  *yourdomain.com/wp-demo-endpoint*. If you have the Permalink settings in "Plain" mode you will need to navigate to this page by your websites navigation or wordpress admin.

When you open the page for the first time it will load a Users list via ajax and builds a table to display its information. You can click either on the user id, the name or the username and a new table will appear on top. In this table you get more detailed information as email, website, address and 3 buttons. The button will load this users albums, posts or todos and shows them in a new table right below. If there is an error in any of these steps a Error pop-up will show a according Error message.
You may recognize that the first load of the page or a user details can take quite long, we'll have to wait for the external Api to reply here. Since the plugin implements caching are all following loads of the same data nearly instant ready.


On deactivation the plugin does the cleanup and deletes the previous created Users Table page.

## Requirements
- php **target version** is **7.3**
- this repo is also tested against *php 7.2* and *php 7.4* 
- composer installed
- curl extension
- jQuery activated


## Scripts

This plugin comes with batteries included:

**Mandatory** update or install dependencies

```bash
composer update
```

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
    	'Endpoint' => 'wp-demo-endpoint',
    	'Fetch Url' => 'https://xxx.yyy.zzz.com/users',
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

This plugin includes 3 different JavaScript files. `jquery-ui.min.js` and `jquery.jtable.min.js` are the used library files, while `rasta-user-fetcher.min.js` configures jTable instance to our needs. See `rasta-user-fetcher.js` for the non-minified development version of `rasta-user-fetcher.min.js`

### Why jTable jQuery extension?

Even though jQuery is left behind in the modern JavaScript world, so is it still a useful tool. It comes by default with a wordpress installation and has a heap of useful extensions as here with *jTable*. *JTable* does the job for our requirements without much trouble just by providing a configuration for the needed tables and elements to attach them to. I just configured the *MVP* but it could be extended easily for the most common needs. This is not intended as a showcase of modern JavaScript development, rather then using a fitting tool.

### Why use a page as endpoint?

The activation process creates a page, attaches a html-element as root for *jTable*  to its content and includes the needed js files to start the app.
We could use a hook based implementation instead and render the app without a *page* object. I tried both and I think that the option to interact with the object in the normal wp context is quite a benefit. As a user it shows in my menues, I can edit the title and even add content above or below the displayed table with my standard tools.

### Testing

Testing is in my book a very core element of coding and is nothing that should be slapped on top of an existing project. To refactor code after the fact to somehow make it pass arbitary test is clearly neither the idea nor does it provide major benefits.

I'm a professional coder and teacher for over 15 years and the biggest improvements in the code quality I've seen with my students or with myself was the adaption of Test driven development. Usually the resulting production code becomes shorter and creates stability for upcoming updates or changes in the host system architecture. I'm not worried that bumping up the PHP version breaks the application, because I already tested that.

The other big plus which is often overlooked is that it helps developers to keep the eyes-on-the-prize by writting the test-case first and therefore define very clearly what they expect a feature has to do. Instead of one huge complex method we end up with a bunch of short methods which can get chained together to do very complex tasts. The re-usability of the modules in the second approach reduces code duplications and keeps it easy to maintain.

#### Testing philosophy

With over 10 years experience in TDD I figured the following as workable approaches

- first we write the test, then we make the test pass, then we rafactor to make it pretty
- we just test **public** methods (ignore **private or protected**, they are just helpers)
- we don't test databases (needs to be mocked, please use **dependency injection** instead)
- we believe that standard functions work (we don't test if `intval()` works, we assume it does)
- Types: if a method is properly type-hinted then we just test the allowed types, we assume php assures we are just getting those
- **test for behavior, not for implementation**: as long as a method returns the expected response, we don't care how it reached the conclusion

### Running the tests

```bash
▶ composer test
> codecept run
Codeception PHP Testing Framework v4.1.3
Powered by PHPUnit 6.5.14 by Sebastian Bergmann and contributors.
Running with seed:


Unit Tests (17) ----------------------------------------------------------------
✔ ActivatorTest: Default construction (0.00s)
✔ ActivatorTest: Custom construction (0.00s)
✔ ActivatorTest: Getter and setter for endpoint (0.00s)
✔ ActivatorTest: Getter and setter for handler (0.00s)
✔ ActivatorTest: Getter and setter for page title (0.00s)
✔ ActivatorTest: Getter and setter for snippet (0.00s)
✔ ActivatorTest: Getter and setter for page (0.00s)
✔ ActivatorTest: Double activation (0.00s)
✔ ActivatorTest: Invalid endpoint activation (0.00s)
✔ ActivatorTest: Double deactivation (0.00s)
✔ ActivatorTest: Invalid deactivation (0.00s)
✔ ActivatorTest: Get js dependencies (0.00s)
✔ ActivatorTest: Load scripts (0.00s)
✔ ApiTest: Default construction (0.00s)
✔ ApiTest: Getter and setter for handler (0.00s)
✔ ApiTest: Error response (0.00s)
✔ ApiTest: Ok response (0.00s)
--------------------------------------------------------------------------------


Time: 63 ms, Memory: 8.00MB

OK (17 tests, 237 assertions)
```


### File `demo-plugin.php`

Is the main entrypoint into the application. Here we define all our actions and hooks in an exposed way, so its offering and easy usability for any kind of developer. Actions can be deactivated by commenting them out or overridden.

### File `src/Activator.php` **class** *Rasta\UserFetcher\Activator*

The *Activator* class is responsible for all steps required to get the plugin up and running and to clean up on deactivation.

It contains the logic for the Activation & Deactivation hook as well as including the required JavaScript files on our UserFetcher page.

### File `src/Api.php` **class** *Rasta\UserFetcher\Api*

The *Api* class is responsible for handling requests while the Plugin is active and at work. It fetches data and exposes it in the correct format for the *jTable* application.

### File `src/Handler.php` **class** *Rasta\UserFetcher\Handler*

This class is the *Dependency Handler* in our current project. It is a good software design pattern to *keep the code modular and agnostic* and reach a *high test-coverage*.

This *Handler* class is composed out of **static** methods which directly use wordpress functionality as `get_page_by_path` , `wp_delete_post` or `fetch` data with the help of `curl_exec`. If one of the regular classes *Activator* or *Api* needs access to one those methods, it calls it via the *Handler*.

Working this way has some useful benefits as I may explain.

#### Testability

If you are working with *TDD* you need to write unit tests which don't have many host features available. To run the tests we have to *mock / monkey patch* certain functionalities to ensure the units can behave as expected. If we use one central *Handler* class all we need to do is to extend it with a `TestHandler` class, override the dependend methods and assign it to our regular class.

The *Handler* class is not supposed to be tested. We assume that `get_page_by_path` or `wp_delete_post` work, so tests would be obsolete.

The isolation of all non-testable features in one class has the big advantage that all the actual business logic is fully testable with very little effort spend in mocking critical parts of many classes.

#### Being modular

We can easily override the *Handler* methods, so we can customize the Plugin to our custom conditions.

Let's have a look inside the `fetch` method

```php

if ($result === false) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $fetch_url);
    $result = curl_exec($ch);
    curl_close($ch);
    ...
}
```
We see that fetching depends on an active **curl** lib for php. Even though it is a common standard library we may encounter a host system with *no curl active*. If we still want to use our plugin we are actually able to do that easily.

```php

class MyHandler extends Handler
{
	public static function fetch(string $fetch_url, $cache_time = 3600)
	{
		// we ignore caching in this example
    	$result = file_get_contents($fetch_url);
		return ($result === false) ? false : json_decode($result);


	}
}

$Api = new Rasta\UserFetcher\Api();
$Apis->setHandler('Myhandler');
```
All fetch requests run through the central *Handler* class, so all requests will now use *file_get_contents* instead of *curl*

To use **Dependency Injections** as our *Handler* class is a common solution in many programming languages and raises the *QoC* in automated code evaluations.


### File `public/js/demo.js`

is the devopment version of the include `rasta-user-fetcher.min.js`.
it shows the configuartion of the *jTable* jQuery extension to fit our requirements. The actual connection between php and Javascript is the hooking of the listAction endpoint:

```php
// php
add_action('wp_ajax_list-users', [$PluginApi, 'fetchUserRequest']);
```

```js
//js
	actions: {
    	listAction: php_vars.user_api +'?action=list-users',
			},
    fields: {...}

```

### File `.editorconfig`

EditorConfig helps maintain consistent coding styles for multiple developers working on the same project across various editors and IDEs.

### File `.travis`

I like to connect TravisCI with my repos to automate workflows as much as possible. Even though it is not active in this private repo I may very well activate it at a later time for automated package releases.

### File `codeception.yml`

configuration for *Codeception* based test

### File `composer.json`

**composer** configuration file. Here we define dependencies, psr-4 namespaces, the handy scripts and basic package information

### File `config.php`

Defines value standards and offers the possibility of a `config.local.php` based overriding of those default values.

### File `phpcs.xml`

configuration file for code sniffer and automated code fixes available via `composer lint:fix`

## About the author

Jens Krause is a german born professional webdeveloper since 2002. He studied Computer Science, worked on international projects all around the world and could provide knowledge and guidance to many younger developers and customers alike throughout the years.

If you have questions or want to get in contact please feel free to write a message to <jens@rasta.online>

