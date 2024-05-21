# Test Palmcode - Zulkifli Raihan

## Minimum Requirement
### Frontend
- Node.js:  18
### Backend
- PHP: 8.2
- Composer: 2.x.x

## How to setup backend

### Neet to do before setup backend
1. Before setup backend, you need go to https://play.min.io:9443/
2. Login with username "minioadmin" and password "minioadmin"
3. Go to menu Access Key and Create new access key. And dont forget to save that.
4. After that, go to Buckets menu. And you need create new buckets.
5. After created the bucket, go to detail bucket and set the "Access Policy" from "Private" to "Public"

### Now Let's setup the backend
1. Go to directory backend
```
cd ./backend
```
2. Install all package backend laravel
```
composer install
```
3. Create file .env
This is my personal .env
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:qa5p+3VMGXSmzc5D3AKGTocUE6GuzxA/XIzAGHuG/zY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=file
SESSION_LIFETIME=120

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

JWT_SECRET=ffRaipOlt8VNHgOgNAQf4VVV2G0pksDBLiIYM1mrX3jPwOkAqo86Kn5RQW4tMt7d

MEDIA_DISK="minio"

MINIO_ENDPOINT="https://play.min.io:9000"
MINIO_PORT=9000
MINIO_ACCESS_KEY=lQs5CPXmg7GeScPvXPAM
MINIO_SECRET_KEY=8sODFP1Z6NKnqjVWd8e77w5ezELxj8IOFoY7jASt
MINIO_SSL=true
MINIO_BUCKET_NAME="zuran-test-palmcode"
MINIO_URL=https://play.min.io:9000/zuran-test-palmcode
```
Change value variable MINIO_ACCESS_KEY, MINIO_SECRET_KEY, MINIO_BUCKET_NAME, MINIO_URL (https://play.min.io:9000/${bucket_name})

4. If using SQL Lite, create a file in ./backend/database and give the name file "database.sqlite"

5. Run migration and seeder
```
php artisan migrate --seed
or 
php artisan migrate:fresh --seed
```

6. Run the project 
```
php artisan serve
```

## How to setup frontend
1. Install all packages or libraries (i prefer using bun)
```
bun install
or 
yarn install
or 
npm install
```

2. Setup .env file 
```
API_URL=http://localhost:8001
```
Change value API_URL to api url backend

3. Run the project
```
bun run dev
or 
bun run build
bun run start
```# new_palmcode
# test_palmcode
# test_palmcode
