-- Step 1: First ensure students_subject has proper primary key
ALTER TABLE `students_subject` 
ADD COLUMN `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

-- Step 2: Create the students_subject_po table
CREATE TABLE `students_subject_po` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `student_subject_id` INT NOT NULL,
    `po_id` INT NOT NULL,
    `po_score` DECIMAL(5,2) DEFAULT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_student_subject_po` 
        FOREIGN KEY (`student_subject_id`) 
        REFERENCES `students_subject`(`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_po` 
        FOREIGN KEY (`po_id`) 
        REFERENCES `program_outcomes`(`id`) 
        ON DELETE CASCADE,
    INDEX `idx_student_subject_id` (`student_subject_id`),
    INDEX `idx_po_id` (`po_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Step 3: Add unique constraint to prevent duplicate entries
ALTER TABLE `students_subject_po`
ADD UNIQUE INDEX `unique_student_po` (`student_subject_id`, `po_id`);

-- Step 4: Transfer existing PO data if needed
INSERT INTO `students_subject_po` (student_subject_id, po_id, po_score)
SELECT 
    ss.id,
    po.id,
    CASE 
        WHEN n.po_num = 1 THEN ss.po1
        WHEN n.po_num = 2 THEN ss.po2
        -- ... add more cases as needed
    END as score
FROM `students_subject` ss
CROSS JOIN (SELECT id, po_code FROM program_outcomes) po
CROSS JOIN (
    SELECT 1 as po_num UNION SELECT 2 UNION SELECT 3 
    UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 
    UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 
    UNION SELECT 10 UNION SELECT 11 UNION SELECT 12 
    UNION SELECT 13 UNION SELECT 14
) n
WHERE CASE 
        WHEN n.po_num = 1 THEN ss.po1 IS NOT NULL
        WHEN n.po_num = 2 THEN ss.po2 IS NOT NULL
        -- ... add more cases as needed
    END;

-- Step 5: Drop old PO columns after successful transfer
ALTER TABLE `students_subject`
DROP COLUMN IF EXISTS `po1`,
DROP COLUMN IF EXISTS `po2`,
DROP COLUMN IF EXISTS `po3`,
DROP COLUMN IF EXISTS `po4`,
DROP COLUMN IF EXISTS `po5`,
DROP COLUMN IF EXISTS `po6`,
DROP COLUMN IF EXISTS `po7`,
DROP COLUMN IF EXISTS `po8`,
DROP COLUMN IF EXISTS `po9`,
DROP COLUMN IF EXISTS `po10`,
DROP COLUMN IF EXISTS `po11`,
DROP COLUMN IF EXISTS `po12`,
DROP COLUMN IF EXISTS `po13`,
DROP COLUMN IF EXISTS `po14`;
