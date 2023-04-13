-- migrate:up

CREATE TABLE body_parts (
	id	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name	VARCHAR(25) NOT NULL
);

-- migrate:down

DROP TABLE IF EXISTS body_parts;