-- migrate:up

ALTER TABLE users
ADD COLUMN state VARCHAR(12) NOT NULL DEFAULT 'PENDING';

-- migrate:down

ALTER TABLE users
DROP COLUMN state;
