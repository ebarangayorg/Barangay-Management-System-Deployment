#!/bin/bash
# Export Railway environment variables to Apache workers
export MONGO_URI=$MONGO_URI
export DB_NAME=$DB_NAME

# Start Apache in foreground
apache2-foreground
