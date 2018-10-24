To process the full YML file run this:
```php command.php```

This expects a file called `image_sets.yml` in the root of the repo and will output `image_sets_modified.yml` as a new file

To process a single image run:
```php command.php extract FILEPATH```
e.g.
```php command.php extract https://s3-eu-west-1.amazonaws.com/basekit-product/Image+Sets/localBusiness/gardener/default/gardener_image-2.jpg```

Memory issues?

If you're having problems with PHP running out of memory you can try adding a memory limit to the call like:
```php command.php -d memory_limit=256M ``
