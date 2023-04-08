-- migrate:up

INSERT INTO disciplines (name) VALUES ('COMPLETO');
INSERT INTO disciplines (name) VALUES ('BAILE');

-- migrate:down

TRUNCATE disciplines;

