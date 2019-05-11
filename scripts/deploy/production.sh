#!/usr/bin/env bash

## Deploy master branch to production server
wget "https://forge.laravel.com/servers/"$FORGE_SERVER"/sites/"$FORGE_SITE"/deploy/http?token="$FORGE_PRODUCTION_TOKEN;
