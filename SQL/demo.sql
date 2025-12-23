-- Job Portal System --

-- create database
CREATE DATABASE job_portal;

-- database
USE job_portal;

-- Users table (job seekers)

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

insert into employers values(2, "John Wick", "QFX", "john.qfx@gmail.com","Pulchowk", "password", )


-- Jobs table

CREATE TABLE jobs(
    id INT AUTO_INCREMENT PRIMARY KEY,
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
    job_level ENUM('Entry','Junior', 'Mid', 'Senior'),
    category VARCHAR(100),
    status ENUM('active', 'inactive') DEFAULT 'active',
    company_id INT NOT NULL,

    CONSTRAINT fk_job_company
        FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Applications table

CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status ENUM('applied','reviewed','shortlisted','rejected','selected'),
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    job_id INT NOT NULL,

    CONSTRAINT fk_application_user
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_application_job
        FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE ON UPDATE CASCADE
);


-- Bookmarks table

CREATE TABLE bookmarks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    job_id INT NOT NULL,

    CONSTRAINT fk_bookmark_user
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_bookmark_job
        FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE ON UPDATE CASCADE,

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