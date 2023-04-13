-- migrate:up

INSERT INTO body_parts (name) VALUES ('ABDOMEN');
INSERT INTO body_parts (name) VALUES ('PIERNAS');
INSERT INTO body_parts (name) VALUES ('PANTORRILLA');
INSERT INTO body_parts (name) VALUES ('PECTORAL');
INSERT INTO body_parts (name) VALUES ('ESPALDA');
INSERT INTO body_parts (name) VALUES ('HOMBROS');
INSERT INTO body_parts (name) VALUES ('BICEPS');
INSERT INTO body_parts (name) VALUES ('TRICEPS');

-- migrate:down

TRUNCATE body_parts;

