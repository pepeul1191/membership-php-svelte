-- migrate:up

INSERT INTO levels (name) VALUES ('SUPERIOR HOMBRE - PRINCIPIANTE');
INSERT INTO levels (name) VALUES ('SUPERIOR HOMBRE - INTERMEDIO');

-- migrate:down

TRUNCATE levels;

