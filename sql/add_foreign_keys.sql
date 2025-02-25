-- Add foreign keys to course_list table
ALTER TABLE `course_list`
ADD CONSTRAINT `fk_course_program`
FOREIGN KEY (`program_id`) REFERENCES `program_list`(`id`)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `course_list`
ADD CONSTRAINT `fk_course_prerequisite`
FOREIGN KEY (`prerequisite`) REFERENCES `course_list`(`id`)
ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `course_list`
ADD CONSTRAINT `fk_course_department`
FOREIGN KEY (`department_id`) REFERENCES `department_list`(`id`)
ON DELETE SET NULL ON UPDATE CASCADE;

-- Add foreign keys to faculty_courses table
ALTER TABLE `faculty_courses`
ADD CONSTRAINT `fk_faculty_course_faculty`
FOREIGN KEY (`faculty_id`) REFERENCES `faculty_list`(`id`)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `faculty_courses`
ADD CONSTRAINT `fk_faculty_course_course`
FOREIGN KEY (`course_id`) REFERENCES `course_list`(`id`)
ON DELETE CASCADE ON UPDATE CASCADE;
