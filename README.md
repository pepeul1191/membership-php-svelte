# FlightPHP con Svelte JS

Instalación de dependencias:

    $ composer install

Servidor de desarrollo

    $ composer start

Usar la versión 18 de node js.

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

.env de la raiz

```
FF_ENVIRONMENT = development
FF_CSRF = true
FF_SESSION = true
FF_API= true
DB="mysql://root:Sila-1234@127.0.0.1:3306/drgym"
FACEBOOK="https://facebook.com/antergo"
INSTAGRAM="https://instagram.com/antergo"
WHASTAPP="+51 901 268 633"
EMAIL_SITE="proyectos@antergo.pe"
ENTERPRISE_NAME="Dr. GYM"
```

.env de helpers

```
MAIL_SENDER=""
MAIL_USER=""
MAIL_PASS=""
MAIL_US=""
MAIL_HOST=""
MAIL_PORT=587
PRIMARY=""
SECONDARY=""
NAME=""
ABOUT=" clientes"
ADRESS=""
PHONE=""
EMAIL=""
MESSAGE=""
DB_USER="root"
DB_PASS="Sila-1234"
DB_NAME="drgym"
CRYPTO_KEY="SuEMnUn8SsqThjyPYQD0tL"
CRYPTO_DOM="softweb.pe"
```

Backup de PhpMyAdmin

ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci; --> ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

## TODO

+ Procedimiento almacenado en la base de datos para actualizar el estado de las membresías de ACTIVO a VENCIDO.
+ Helpers/mail_helper -> resetMail