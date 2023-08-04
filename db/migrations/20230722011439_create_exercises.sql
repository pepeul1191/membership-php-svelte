-- migrate:up

CREATE TABLE exercises (
	id	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(45) NOT NULL,
  image_url VARCHAR(30) NOT NULL,
  video_url VARCHAR(100) NOT NULL,
  body_part_id	INT,
  FOREIGN KEY(`body_part_id`) REFERENCES exercises ( id ) ON DELETE CASCADE
);

-- migrate:down

DROP TABLE IF EXISTS exercises;
