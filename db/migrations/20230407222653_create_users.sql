-- migrate:up

CREATE TABLE users (
	id	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user	VARCHAR(45) NOT NULL,
  password	VARCHAR(60) NOT NULL,
	reset_key	VARCHAR(20),
  activation_key	VARCHAR(25)
);

-- migrate:down

DROP TABLE IF EXISTS users;