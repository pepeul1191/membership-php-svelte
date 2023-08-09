-- migrate:up

INSERT INTO membership_states (name) VALUES ('ACTIVO');
INSERT INTO membership_states (name) VALUES ('SUSPENDIDO');
INSERT INTO membership_states (name) VALUES ('VENCIDO');

-- migrate:down

TRUNCATE membership_states;

