CREATE TABLE learning_outcomes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    learning_outcome_code VARCHAR(50) NOT NULL,
    learning_outcome TEXT NOT NULL,
    FOREIGN KEY (course_id) REFERENCES course_list(id) ON DELETE CASCADE
);
