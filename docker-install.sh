#!/bin/bash

set -exuo pipefail

# Build the containers
docker-compose up -d

# Composer install
docker-compose exec php composer install --ignore-platform-reqs

# Wait
docker-compose exec php /wait

# Installer
docker-compose exec php php cli-install.php
