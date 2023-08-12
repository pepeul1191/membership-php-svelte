-- migrate:up

CREATE TABLE packages_exercises (
	id	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  position	INT,
  reps	INT,
  sets	INT,
  package_id	INT,
  exercise_id	INT,
  FOREIGN KEY(`package_id`) REFERENCES packages ( id ) ON DELETE CASCADE,
  FOREIGN KEY(`exercise_id`) REFERENCES exercises ( id ) ON DELETE CASCADE
);

-- migrate:down

DROP TABLE IF EXISTS packages_exercises;