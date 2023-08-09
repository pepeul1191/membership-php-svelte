-- migrate:up

CREATE TABLE membership_states (
	id	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name	VARCHAR(12) NOT NULL
);

-- migrate:down

DROP TABLE IF EXISTS membership_states;