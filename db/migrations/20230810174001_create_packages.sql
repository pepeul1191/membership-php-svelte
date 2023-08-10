-- migrate:up

CREATE TABLE packages (
	id	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name	VARCHAR(60) NOT NULL,
  membership_id	INT,
  FOREIGN KEY(`membership_id`) REFERENCES memberships ( id ) ON DELETE CASCADE
);

-- migrate:down

DROP TABLE IF EXISTS packages;