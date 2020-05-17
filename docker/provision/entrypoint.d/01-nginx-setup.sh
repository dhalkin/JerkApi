#!/usr/bin/env bash

# Exit the script if any statement returns a non-true return value
set -e

/usr/local/bin/go-replace --regex -s '\bSERVICE_NAME\b' -r ${SERVICE_NAME} /etc/nginx/sites-enabled/app.conf