-- migrate:up

INSERT INTO members (names, last_names, email, code, phone, medical_obs, discipline_id) 
  VALUES ('José Jesús', 'Valdivia Caballero', 'pepe.valdivia.caballero@gmail.com', 'XD-9773', '190839012', 'Espondilitis Anquilosante hace 20 años', 1);
INSERT INTO members (names, last_names, email, code, phone, medical_obs, discipline_id) 
  VALUES ('Yacky', 'Rmirez', 'yacky@gmail.com', 'XD-9774', '19083903', 'Es espesa nomas', 1);

-- migrate:down

TRUNCATE members;