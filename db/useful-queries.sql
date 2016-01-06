-- all overall expectation (titles only) for a course
select s.id as sid, s.code as scode, s.title as stitle, o.id as oid, o.code as ocode, o.title as otitle
from course c
inner join strand s
on s.course_id = c.id
inner join overall_expectation o
on o.strand_id = s.id
where c.id = 1;

-- all minor expectations for a course
select s.id as sid, s.code as scode, s.title as stitle, o.id as oid, o.code as ocode, o.title as otitle, m.id as mid, m.code as mcode, m.description as mdescription
from course c
inner join strand s
on s.course_id = c.id
inner join overall_expectation o
on o.strand_id = s.id
inner join minor_expectation m
on m.overall_expectation_id = o.id
where c.id = 1;

-- count of minor expectations for a course
select count(m.id)
from course c
inner join strand s
on s.course_id = c.id
inner join overall_expectation o
on o.strand_id = s.id
inner join minor_expectation m
on m.overall_expectation_id = o.id
where c.id = 1;
