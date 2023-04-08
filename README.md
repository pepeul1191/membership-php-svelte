# FlightPHP con Svelte JS

Instalación de dependencias:

    $ composer install

Servidor de desarrollo

    $ composer start

### Migraciones

Migraciones con DBMATE - accesos/sqlite3:

    $ dbmate -d "db/migrations" -e "DB" new <<nombre_de_migracion>>
    $ dbmate -d "db/migrations" -e "DB" up
    $ dbmate -d "db/migrations" -e "DB" rollback

## Archivo .env

    ENV="local"||"prod"

### Dump y Restore Mysql

    $ mysqldump -u root -p --ignore-table=vw_project_types_projects antergo > db/antergo.sql
    $ mysql -u root -p antergo < db/antergo.sql

## Habilitar GROUP BY MySQL

    $ SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));