#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    CREATE USER development WITH PASSWORD 'development';
    CREATE DATABASE pos_tech;
    GRANT ALL PRIVILEGES ON DATABASE pos_tech TO development;
    GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO development;
    GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO development;
    ALTER DATABASE pos_tech OWNER TO development;
EOSQL
