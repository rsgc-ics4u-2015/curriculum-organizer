-- all overall expectation (titles only) for a course
SELECT s.id AS sid, s.code AS scode, s.title AS stitle, o.id AS oid, o.code AS ocode, o.title AS otitle
FROM course c
INNER JOIN strand s
ON s.course_id = c.id
INNER JOIN overall_expectation o
ON o.strand_id = s.id
WHERE c.id = 1;

-- all minor expectations for a course
SELECT s.id AS sid, s.code AS scode, s.title AS stitle, o.id AS oid, o.code AS ocode, o.title AS otitle, m.id AS mid, m.code AS mcode, m.description AS mdescription
FROM course c
WHERE strand s
ON s.course_id = c.id
INNER JOIN overall_expectation o
ON o.strand_id = s.id
INNER JOIN minor_expectation m
ON m.overall_expectation_id = o.id
WHERE c.id = 1;

-- count of minor expectations for a course
SELECT COUNT(m.id) AS expectations_count
FROM course c
INNER JOIN strand s
ON s.course_id = c.id
INNER JOIN overall_expectation o
ON o.strand_id = s.id
INNER JOIN minor_expectation m
ON m.overall_expectation_id = o.id
WHERE c.id = 1;
