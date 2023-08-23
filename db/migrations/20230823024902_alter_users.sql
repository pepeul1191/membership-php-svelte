-- migrate:up

ALTER TABLE users
MODIFY user	VARCHAR(45);

ALTER TABLE users
MODIFY password	VARCHAR(60);

-- migrate:down

ALTER TABLE users
MODIFY user	VARCHAR(45) NOT NULL;

ALTER TABLE users
MODIFY password	VARCHAR(60) NOT NULL;