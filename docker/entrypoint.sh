#!/bin/sh
#
# This file is part of the Zemit Framework.
#
# (c) Zemit Team <contact@zemit.com>
#
# For the full copyright and license information, please view the LICENSE.txt
# file that was distributed with this source code.
#

# Define the database host and port
DB_HOST=db
DB_PORT=3306

# Function to wait for the database to be ready
wait_for_db() {
    echo "Waiting for database at $DB_HOST:$DB_PORT..."
    while ! nc -z $DB_HOST $DB_PORT; do   
        sleep 1
    done
    echo "Database is up!"
}

# Change to the working directory
cd "$WORKDIR_PATH" || exit 1

# creating .zemit directory
mkdir -p .zemit

# Wait for the database to be ready
wait_for_db

# run the migration
echo 'Running the migration...';
./bin/migration-run.sh

# Fix the database tables engines
echo 'Fixing database tables engines';
php ./zemit cli database fix-engine

# Optimize the database tables
echo 'Optimizing database tables';
php ./zemit cli database optimize

# Analyze the database tables
echo 'Analyzing database tables';
php ./zemit cli database analyze

# Check if the first-time setup needs to run
if [ ! -f ".zemit/database-initialized" ]; then
    echo "Initializing database..."
  
    # Drop unused database tables
    echo "Dropping database tables"
    php ./zemit cli database drop
    
    # Truncate existing database tables
    echo "Truncating database tables"
    php ./zemit cli database truncate
    
    # Insert new database records
    echo "Inserting database records"
    php ./zemit cli database insert

    # Mark setup as complete
    echo "Database initialized!"
    touch ".zemit/database-initialized"
fi

# Proceed with container's main process
exec "$@"
