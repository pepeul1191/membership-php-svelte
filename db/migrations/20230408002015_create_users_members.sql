-- migrate:up

CREATE TABLE users_members (
	id	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id	INT,
  member_id	INT,
  FOREIGN KEY(`user_id`) REFERENCES users ( id ) ON DELETE CASCADE,
  FOREIGN KEY(`member_id`) REFERENCES members ( id ) ON DELETE CASCADE
);

-- migrate:down

DROP TABLE IF EXISTS users_members;