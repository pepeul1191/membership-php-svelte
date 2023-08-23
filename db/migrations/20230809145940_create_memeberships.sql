-- migrate:up

CREATE TABLE memberships (
	id	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  beginning	DATE NOT NULL,
  ending	DATE NOT NULL,
  member_id	INT,
  FOREIGN KEY(`member_id`) REFERENCES members ( id ) ON DELETE CASCADE
);

-- migrate:down

DROP TABLE IF EXISTS memberships;