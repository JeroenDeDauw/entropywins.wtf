# bn2vs.com website

This repo contains the resources of the [bn2vs.com website](http://bn2vs.com).

The website uses the [Silex](silex.sensiolabs.org/) PHP micro-framework.

### Ops

The web root is in `www`. This needs to be accessible by the web server and PHP enabled.
The other folders should not be web accessible.

Caching and logging data gets written to `var`.

### Developing

When the production entry point `www/index.php` and the production config `config/prod.php` are used,
things get cached. This can be annoying when developing. This is why there is an alternate entry
point `www/index_dev.php`. When navigating to a new page, `index.php` will be used again. Not sure
how to best avoid this, but one can temporarily change the production config or simply rename the
entry points to `index_prod.php` and `index.php`.

The page content is defined in files in `templates`. The layout it defined in `layout.html`, with
the other files defining the body content of a single page each.

The routing is done in `src/controllers.php`.

For developing, you can simply run `php -S localhost:8000` in `www`. No need to have a real server
set up.