Elgg Starter Project [![Build Status](https://travis-ci.org/Elgg/starter-project.svg?branch=master)](https://travis-ci.org/Elgg/starter-project)
====

This is highly experimental and work-in-progress feature. It comes down to being able to use Elgg's core 
in main project as a composer dependency. For more context have a look at https://github.com/Elgg/Elgg/issues/7721

## Installation

```shell
cd /path/to/wwwroot
curl -s http://getcomposer.org/installer | php
php composer.phar global require "fxp/composer-asset-plugin:~1.0"
php composer.phar create-project elgg/starter-project:dev-master .
```