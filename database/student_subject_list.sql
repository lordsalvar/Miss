DROP TABLE IF EXISTS `student_subject_list`;
CREATE TABLE IF NOT EXISTS `student_subject_list` (
    `id` int(30) NOT NULL AUTO_INCREMENT,
    `student_id` int(30) NOT NULL,
    `course_id` int(30) NOT NULL,  -- Changed from subject_id to course_id
    `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `status` tinyint(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`),
    KEY `student_id` (`student_id`),
    KEY `course_id` (`course_id`),
    CONSTRAINT `fk_student_subject_student` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_student_subject_course` FOREIGN KEY (`course_id`) REFERENCES `course_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
