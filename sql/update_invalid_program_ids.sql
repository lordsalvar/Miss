-- Update invalid program_id values to a valid program_id (e.g., 1)
UPDATE course_list
SET program_id = 1
WHERE program_id NOT IN (SELECT id FROM program_list);
