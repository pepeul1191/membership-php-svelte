# FlightPHP con Svelte JS

Instalación de dependencias:

    $ composer install

Servidor de desarrollo

    $ composer start

### Migraciones

Migraciones con DBMATE - accesos/sqlite3:

    $ npm run dbmate:new <<nombre_de_migracion>>
    $ npm run dbmate:up
    $ npm run dbmate:rollback

## Archivo .env

    ENV="local"||"prod"

### Dump y Restore Mysql

    $ mysqldump -u root -p --ignore-table=vw_project_types_projects antergo > db/antergo.sql
    $ mysql -u root -p antergo < db/antergo.sql

## Habilitar GROUP BY MySQL

    $ SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));