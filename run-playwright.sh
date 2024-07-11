#!/bin/bash
# docker compose run --rm playwright node plugin.test.js
docker run -p 8000:8000 --rm --init -it mcr.microsoft.com/playwright:v1.45.1-jammy /bin/sh -c "cd ./ && npx -y playwright@1.41.0 run-server --port 8000 --host 0.0.0.0"