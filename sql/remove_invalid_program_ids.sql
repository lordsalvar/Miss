-- Remove rows with invalid program_id values
DELETE FROM course_list
WHERE program_id NOT IN (SELECT id FROM program_list);
