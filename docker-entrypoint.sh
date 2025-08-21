#!/bin/bash
set -e

# Run Laravel migrations
php artisan migrate --force

# Start Apache in foreground
exec "$@"
