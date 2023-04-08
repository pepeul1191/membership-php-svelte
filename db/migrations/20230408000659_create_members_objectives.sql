-- migrate:up

CREATE TABLE members_objectives (
	id	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  member_id	INT,
  objective_id	INT,
  FOREIGN KEY(`member_id`) REFERENCES members ( id ) ON DELETE CASCADE,
  FOREIGN KEY(`objective_id`) REFERENCES objectives ( id ) ON DELETE CASCADE
);

-- migrate:down

DROP TABLE IF EXISTS members_objectives;