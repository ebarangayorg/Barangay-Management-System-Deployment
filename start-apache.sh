#!/bin/bash
# Export environment variables for Apache workers
export MONGO_URI=$MONGO_URI
export DB_NAME=$DB_NAME

# Debug (optional)
# echo "MONGO_URI=$MONGO_URI"
# echo "DB_NAME=$DB_NAME"

# Start Apache in foreground
apache2-foreground
