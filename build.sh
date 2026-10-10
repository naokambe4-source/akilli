#!/bin/sh
# Builds installable ZIPs into dist/.
set -e
cd "$(dirname "$0")"
mkdir -p dist
rm -f dist/akilli-creative.zip dist/akilli-core.zip
zip -rq dist/akilli-creative.zip akilli-creative -x '*.DS_Store'
zip -rq dist/akilli-core.zip akilli-core -x '*.DS_Store'
ls -la dist
