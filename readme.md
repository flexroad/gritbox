Gritbox - a Nette project starter
=============

Gritbox is a pre-packaged and pre-configured Nette Framework application
that you can use as the skeleton for your new applications.

It is based on these technologies:

- PHP
- Nette (PHP framework)
- Bootstrap (CSS framework)
- Grunt (Javascript Task Runner)
- LESS (CSS pre-processor)
- jQuery (Javasript framework)
- Bower (Package manager)

Features
--------

- User handling: Login, Register, Forgotten password
- Flashmessage UX (stay always visible)

Installing
----------

The best way to install Gritbox is using Composer. If you don't have Composer yet, download
it following [the instructions](http://doc.nette.org/composer). Then use command:

		composer create-project gritbox/gritbox my-app
		cd my-app

Make directories `temp` and `log` writable. Navigate your browser
to the `www` directory and you will see a welcome page. PHP 5.4 allows
you run `php -S localhost:8888 -t www` to start the web server and
then visit `http://localhost:8888` in your browser.

It is CRITICAL that whole `app`, `log` and `temp` directories are NOT accessible
directly via a web browser! See [security warning](http://nette.org/security-warning).

Grunt and Grunt plugins are installed and managed via npm, the Node.js package manager. So
be sure, you have them installed. Also, you have to have installed Grunt and Bower.

After you have Gritbox downloaded by Composer, run

	npm install

which will install all Grunt packages into `node_modules` directory.

Then run

	bower install

which will install CSS and JS libraires into `www/components` directory.

License
-------
- Nette: New BSD License or GPL 2.0 or 3.0 (http://nette.org/license)
- jQuery: MIT License (https://jquery.org/license)
- Adminer: Apache License 2.0 or GPL 2 (http://www.adminer.org)
- Sandbox: The Unlicense (http://unlicense.org)
- Grunt: MIT License (https://github.com/gruntjs/grunt/blob/master/LICENSE-MIT)
- Bootstrap: MIT License (https://github.com/twbs/bootstrap/blob/master/LICENSE)