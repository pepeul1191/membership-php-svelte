-- migrate:up

CREATE TABLE members (
	id	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  names	VARCHAR(30) NOT NULL,
  last_names	VARCHAR(35) NOT NULL,
  email	VARCHAR(50) NOT NULL,
	code	VARCHAR(9) NOT NULL,
  phone	VARCHAR(25),
  medical_obs	VARCHAR(70),
  discipline_id	INT,
  FOREIGN KEY(`discipline_id`) REFERENCES disciplines ( id ) ON DELETE CASCADE
);

-- migrate:down

DROP TABLE IF EXISTS members;