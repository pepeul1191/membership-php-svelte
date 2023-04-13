-- migrate:up

CREATE TABLE levels (
	id	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name	VARCHAR(60) NOT NULL
);

-- migrate:down

DROP TABLE IF EXISTS levels;