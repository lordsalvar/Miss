-- Create graduate_attributes table
CREATE TABLE graduate_attributes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attribute VARCHAR(255) NOT NULL
);

-- Create graduate_outcomes table
CREATE TABLE graduate_outcomes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    outcome VARCHAR(255) NOT NULL
);

-- Create po_go table
CREATE TABLE po_go (
    id INT AUTO_INCREMENT PRIMARY KEY,
    po_go_code VARCHAR(50) NOT NULL
);

-- Create igo_go table
CREATE TABLE igo_go (
    id INT AUTO_INCREMENT PRIMARY KEY,
    igo_infused TEXT NOT NULL
);

-- Create performance_indicator table
CREATE TABLE performance_indicator (
    id INT AUTO_INCREMENT PRIMARY KEY,
    indicator VARCHAR(255) NOT NULL
);

-- Create program_outcomes table
CREATE TABLE program_outcomes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    graduate_attribute_id INT,
    graduate_outcome_id INT,
    po_go_id INT,
    igo_go_id INT,
    performance_indicator_id INT,
    course_id INT,
    FOREIGN KEY (graduate_attribute_id) REFERENCES graduate_attributes(id),
    FOREIGN KEY (graduate_outcome_id) REFERENCES graduate_outcomes(id),
    FOREIGN KEY (po_go_id) REFERENCES po_go(id),
    FOREIGN KEY (igo_go_id) REFERENCES igo_go(id),
    FOREIGN KEY (performance_indicator_id) REFERENCES performance_indicator(id),
    FOREIGN KEY (course_id) REFERENCES program_list(id)
);

-- Insert sample data into graduate_attributes
INSERT INTO graduate_attributes (attribute) VALUES ('Attribute 1'), ('Attribute 2');

-- Insert sample data into graduate_outcomes
INSERT INTO graduate_outcomes (outcome) VALUES ('Outcome 1'), ('Outcome 2');

-- Insert sample data into po_go
INSERT INTO po_go (po_go_code) VALUES ('PO1'), ('PO2');

-- Insert sample data into igo_go
INSERT INTO igo_go (igo_infused) VALUES ('IGO1'), ('IGO2');

-- Insert sample data into performance_indicator
INSERT INTO performance_indicator (indicator) VALUES ('Indicator 1'), ('Indicator 2');

-- Insert sample data into program_outcomes
INSERT INTO program_outcomes (graduate_attribute_id, graduate_outcome_id, po_go_id, igo_go_id, performance_indicator_id, course_id) 
VALUES (1, 1, 1, 1, 1, 1), (2, 2, 2, 2, 2, 2);
