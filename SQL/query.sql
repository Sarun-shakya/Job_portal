-- Job Portal System --

-- create database
CREATE DATABASE job_portal;

-- database
USE job_portal;

-- Create Table "Jobs"
CREATE TABLE jobs(
    job_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(150) NOT NULL,
    salary_min DECIMAL(10, 2) DEFAULT 0,
    salary_max DECIMAL(10, 2) DEFAULT 0,
    posted_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    experience_min INT DEFAULT 0,
    experience_max INT DEFAULT 0,
    expiry_date DATE,
    degree VARCHAR(150),
    job_type ENUM('Full time', 'Part time', 'Internship', 'Remote', 'Contract'),
    job_level ENUM('Entry','Junior', 'Mid', 'Senior')
    category VARCHAR(100),
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Insert Dummy jobs values
INSERT INTO jobs 
(title, description, location, salary_min, salary_max, experience_min, experience_max, expiry_date, degree, job_type, job_level)
VALUES
('Frontend Developer', 
 'Develop and maintain responsive web applications using React and modern frontend technologies.',
 'Kathmandu, Nepal',
 30000, 50000,
 1, 3,
 '2025-12-31',
 'Bachelor',
 'Full time',
 'Junior'),

('React Developer', 
 'Build reusable components and ensure high performance of web applications.',
 'Lalitpur, Nepal',
 35000, 55000,
 2, 4,
 '2025-11-30',
 'Bachelor',
 'Full time',
 'Mid'),

('UI/UX Developer', 
 'Collaborate with designers to implement user-friendly interfaces and improve UX.',
 'Bhaktapur, Nepal',
 28000, 45000,
 0, 2,
 '2025-12-15',
 'Bachelor',
 'Full time',
 'Entry'),

('Frontend Intern', 
 'Assist in developing web projects and learn frontend frameworks in a professional environment.',
 'Kathmandu, Nepal',
 0, 0,
 0, 0,
 '2025-10-31',
 'None',
 'Internship',
 'Entry'),

('Remote Frontend Developer', 
 'Work remotely on web applications using React, Vue.js or Angular.',
 'Remote',
 40000, 60000,
 2, 5,
 '2025-12-31',
 'Bachelor',
 'Remote',
 'Mid'),

('Senior Frontend Developer', 
 'Lead frontend development projects, mentor junior developers, and ensure code quality.',
 'Kathmandu, Nepal',
 60000, 90000,
 5, 8,
 '2026-01-15',
 'Master',
 'Full time',
 'Senior');
 
 -- Select the values
 SELECT * FROM jobs;
 
 SELECT title, location, COUNT(*) AS count
FROM jobs
GROUP BY title, location
HAVING count > 1;

SHOW TRIGGERS LIKE 'jobs';


ALTER TABLE jobs 
ADD status ENUM('active', 'inactive') 
NOT NULL DEFAULT 'active';


ALTER TABLE jobs ADD COLUMN category VARCHAR(50);


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    address VARCHAR(150),
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_photo VARCHAR(255),
    resume VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (full_name, address, email, password, profile_photo, resume) VALUES
('John Doe', 'Kathmandu, Nepal', 'john.doe@example.com', '$2y$10$6c3EonQSZoPNL3yv145xeOD7lU20mGNq1bPgJJTdUdD2rzBvzRf1a', 'uploads/john.jpg', 'uploads/john_resume.pdf');

SELECT * FROM users;

-- Bookmarks table

CREATE TABLE bookmarks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    job_id INT NOT NULL,

    CONSTRAINT fk_bookmark_user
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_bookmark_job
        FOREIGN KEY (job_id) REFERENCES jobs(job_id) ON DELETE CASCADE ON UPDATE CASCADE,

    UNIQUE (user_id, job_id)
);  


-- applications table
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status ENUM('applied','reviewed','shortlisted','rejected','selected') DEFAULT 'applied',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    job_id INT NOT NULL,

    CONSTRAINT fk_application_user
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,

    CONSTRAINT fk_application_job
        FOREIGN KEY (job_id) REFERENCES jobs(job_id) ON DELETE CASCADE
);


--alter table job

ALTER TABLE jobs
ADD COLUMN employer_id INT NOT NULL AFTER status;

ALTER TABLE jobs
ADD CONSTRAINT fk_job_employer
FOREIGN KEY (employer_id) 
REFERENCES employers(id)
ON DELETE CASCADE
ON UPDATE CASCADE;


-- alter table applications
ALTER TABLE applications
ADD COLUMN employer_id INT NULL AFTER job_id;

UPDATE applications SET employer_id = NULL WHERE id > 0;

ALTER TABLE applications
ADD CONSTRAINT fk_application_employer
FOREIGN KEY (employer_id)
REFERENCES employers(id)
ON DELETE SET NULL
ON UPDATE CASCADE;


-- Bookmarks table

CREATE TABLE bookmarks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    job_id INT NOT NULL,

    CONSTRAINT fk_bookmark_user
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_bookmark_job
        FOREIGN KEY (job_id) REFERENCES jobs(job_id) ON DELETE CASCADE ON UPDATE CASCADE,

    UNIQUE (user_id, job_id)
); 


-- Admins table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Employers table

CREATE TABLE employers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    location VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    logo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

