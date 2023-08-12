SELECT T.exercise_id, T.exercise, T.body_part_id, T.body_part_name,
	(CASE WHEN (P.position IS NULL) THEN 0 ELSE P.position END) AS position, 
	(CASE WHEN (P.reps IS NULL) THEN 0 ELSE P.reps END) AS reps, 
	(CASE WHEN (P.sets IS NULL) THEN 0 ELSE P.sets END) AS reps
FROM (
	SELECT 
		E.id AS exercise_id, 
		E.name AS exercise, 
		E.body_part_id, 
		BP.name AS body_part_name, 
		0 AS position, 
		0 AS reps, 
		0 AS sets
	FROM body_parts BP 
	INNER JOIN exercises E ON BP.id = E.body_part_id
) T
LEFT JOIN 
(
	SELECT 
		E.id AS exercise_id, 
		E.name AS exercise, 
		E.body_part_id, 
		BP.name AS body_part_name,
		IFNULL(PE.position, 0) AS position, 
		IFNULL(PE.reps, 0) AS reps, 
		IFNULL(PE.sets, 0) AS sets
	FROM exercises E 
	INNER JOIN body_parts BP ON BP.id = E.body_part_id
	INNER JOIN packages_exercises PE ON PE.exercise_id = E.id
	WHERE PE.package_id = 1
) P 
ON T.exercise_id = P.exercise_id ORDER BY body_part_id