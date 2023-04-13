-- migrate:up

INSERT INTO objectives (name) VALUES ('BAJAR DE PESO');
INSERT INTO objectives (name) VALUES ('AUMENTAR MASA MUSCULAR');

-- migrate:down

TRUNCATE objectives;

