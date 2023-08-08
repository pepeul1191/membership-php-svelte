-- migrate:up

CREATE TABLE exercises (
	id	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(45) NOT NULL,
  image_url VARCHAR(60) NOT NULL,
  video_url VARCHAR(100) NOT NULL,
  body_part_id	INT,
  FOREIGN KEY(`body_part_id`) REFERENCES body_parts ( id ) ON DELETE CASCADE
);

-- migrate:down

DROP TABLE IF EXISTS exercises;
