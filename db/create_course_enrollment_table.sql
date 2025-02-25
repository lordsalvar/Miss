CREATE TABLE `course_enrollment` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `student_id` int(11) NOT NULL,
    `school_year` varchar(10) NOT NULL,
    `semester` int(1) NOT NULL,
    `courses` json NOT NULL,
    PRIMARY KEY (`id`),
    KEY `student_id` (`student_id`),
    CONSTRAINT `course_enrollment_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
