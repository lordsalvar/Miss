
-- Create faculty_courses table
CREATE TABLE `faculty_courses` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `faculty_id` INT NOT NULL,
    `course_id` INT NOT NULL,
    `course_title` VARCHAR(255) NULL,
    `date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_faculty_courses_faculty` 
        FOREIGN KEY (`faculty_id`) 
        REFERENCES `faculty_list`(`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_faculty_courses_course` 
        FOREIGN KEY (`course_id`) 
        REFERENCES `course_list`(`id`) 
        ON DELETE CASCADE,
    UNIQUE KEY `unique_faculty_course` (`faculty_id`, `course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add indexes for better performance
CREATE INDEX `idx_faculty_courses_faculty` ON `faculty_courses`(`faculty_id`);
CREATE INDEX `idx_faculty_courses_course` ON `faculty_courses`(`course_id`);
