SELECT DISTINCT program_id
FROM course_list
WHERE program_id NOT IN (SELECT id FROM program_list);
