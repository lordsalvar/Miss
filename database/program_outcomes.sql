
-- Create table for storing student grades per course and program outcome
CREATE TABLE `student_grades` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `student_id` INT NOT NULL,
    `course_id` INT NOT NULL,
    `po_code` VARCHAR(20) NOT NULL,
    `grade` DECIMAL(3,1) NOT NULL,
    `date_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_grade` (`student_id`, `course_id`, `po_code`),
    CONSTRAINT `fk_student_grades_student` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`),
    CONSTRAINT `fk_student_grades_course` FOREIGN KEY (`course_id`) REFERENCES `course_list` (`id`),
    CONSTRAINT `check_grade_range` CHECK (`grade` >= 1.0 AND `grade` <= 9.0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
