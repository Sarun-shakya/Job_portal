-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: job_portal
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` enum('applied','reviewed','shortlisted','rejected','selected') DEFAULT 'applied',
  `applied_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `job_id` int NOT NULL,
  `employer_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_application_user` (`user_id`),
  KEY `fk_application_job` (`job_id`),
  KEY `fk_application_employer` (`employer_id`),
  CONSTRAINT `fk_application_employer` FOREIGN KEY (`employer_id`) REFERENCES `employers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_application_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_application_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applications`
--

LOCK TABLES `applications` WRITE;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
INSERT INTO `applications` VALUES (1,'applied','2025-12-04 15:31:55',6,5,NULL),(2,'applied','2025-12-04 15:34:33',6,7,NULL),(3,'applied','2025-12-04 15:37:37',6,21,NULL),(4,'applied','2025-12-04 15:49:24',6,26,NULL),(5,'reviewed','2025-12-05 11:02:55',6,6,NULL),(6,'shortlisted','2025-12-05 11:30:04',6,22,NULL),(7,'applied','2025-12-05 14:42:26',11,28,NULL),(8,'selected','2025-12-06 14:24:08',11,5,NULL),(9,'reviewed','2025-12-09 09:03:33',11,22,NULL),(10,'reviewed','2025-12-09 15:32:25',12,30,NULL),(11,'applied','2025-12-10 05:21:12',6,31,NULL);
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookmarks`
--

DROP TABLE IF EXISTS `bookmarks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookmarks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `job_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`job_id`),
  KEY `fk_bookmark_job` (`job_id`),
  CONSTRAINT `fk_bookmark_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bookmark_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookmarks`
--

LOCK TABLES `bookmarks` WRITE;
/*!40000 ALTER TABLE `bookmarks` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookmarks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employers`
--

DROP TABLE IF EXISTS `employers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `location` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employers`
--

LOCK TABLES `employers` WRITE;
/*!40000 ALTER TABLE `employers` DISABLE KEYS */;
INSERT INTO `employers` VALUES (1,'John Wick','TechSolutions','hr@techsolutions.com','Kathmandu, Nepal','$2y$10$kb/RLsn/HB4cl.9Ry2qEx.afY8YbeKAy3ETEBYsZ7qo1RTzSbGMKi','techsolutions_logo.jpg','2025-11-09 15:25:04'),(2,'Sarun Shakya','QFX Cinemas','sarun.qfx@gmail.com','Pulchowk, Lalitpur','$2y$10$2.Lj6jOwk8J3iOjPhHM.Uusy2h.vWv2ZiIAVITCTLrXdSILhl3LnW','1764944027_qfx.png','2025-12-05 14:13:47'),(3,'Shyam Singh','E-sewa','shyam.esewa@gmail.com','Gairidhara, Kathmandu','$2y$10$IXsVO5dubF5xKo3DTz8Maujcy5Hu0ffzRRuV8p73aaVDvBbdfpjX6','1764947374_esewa.png','2025-12-05 15:09:34'),(4,'Gopal Thapa','khalti','gopal@gmail.com','Gwarko Lalitpur','$2y$10$DwKRy/RX1EqBcyYfAmaOnuORFrKAuIkHAuttFhmXVCNpSwsCyx5Om','1765339072_khalti.png','2025-12-10 03:57:53'),(5,'Ram Thapa','xyz','ram@gmail.com','Pulchowk, Lalitpur','$2y$10$TcHp3rpZPmSvEZCcvueRCuHxV0iI.6IBKJpD/qvTA16nmGDWAcAge',NULL,'2025-12-10 05:17:59');
/*!40000 ALTER TABLE `employers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `job_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(150) NOT NULL,
  `salary_min` decimal(10,2) DEFAULT '0.00',
  `salary_max` decimal(10,2) DEFAULT '0.00',
  `posted_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `experience_min` int DEFAULT '0',
  `experience_max` int DEFAULT '0',
  `expiry_date` date DEFAULT NULL,
  `degree` varchar(150) DEFAULT NULL,
  `job_type` enum('Full time','Part time','Internship','Remote','Contract') DEFAULT NULL,
  `job_level` enum('Entry','Junior','Mid','Senior') DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `employer_id` int DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`job_id`),
  KEY `fk_job_employer` (`employer_id`),
  CONSTRAINT `fk_job_employer` FOREIGN KEY (`employer_id`) REFERENCES `employers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (5,'Remote Frontend Developer','Work remotely on web applications using React, Vue.js or Angular.','Remote',40000.00,60000.00,'2025-09-23 05:16:31',2,5,'2025-12-31','Bachelor','Remote','Mid','inactive',1,NULL),(6,'Senior Frontend Developer','Lead frontend development projects, mentor junior developers, and ensure code quality.','Kathmandu, Nepal',60000.00,90000.00,'2025-09-23 05:16:31',5,8,'2026-01-15','Master','Full time','Senior','active',1,NULL),(7,'Devops Engineer','Develop and maintain responsive web applications using React and modern frontend technologies.','Lalitpur, Nepal',50000.00,80000.00,'2025-09-23 05:52:40',1,3,'2025-12-31','Masters','Part time','Senior','active',1,NULL),(20,'Frontend Developer','<p><strong class=\"ql-size-large\">Job Description</strong></p><ul><li>Plan, execute, and oversee projects from initiation to completion, ensuring timely delivery within scope and budget.</li><li>Coordinate and collaborate with cross-functional teams, including developers, designers, and stakeholders.</li><li>Define project objectives, milestones, and deliverables, and track progress against them.</li><li>Identify potential risks and issues, and implement mitigation strategies.</li><li>Ensure effective communication among team members, clients, and management.</li><li>Monitor project performance using appropriate tools and methodologies.</li><li>Contribute ideas to improve processes, team efficiency, and overall project quality.</li></ul><p><strong class=\"ql-size-large\">Job Specification</strong></p><ul><li>Bachelor’s degree in Computer Science, IT, Business Administration, or a related field.</li><li>Proven experience as a Project Manager (1–3 years preferred).</li><li>Strong understanding of project management methodologies (Agile, Scrum, Waterfall).</li><li>Excellent organizational, planning, and time-management skills.</li><li>Proficiency in project management tools (e.g., Jira, Trello, Asana, MS Project).</li><li>Strong problem-solving, decision-making, and leadership abilities.</li><li>Effective communication and stakeholder management skills.</li></ul><p><strong class=\"ql-size-large\">What We Offer</strong></p><ul><li>Competitive salary based on skills and experience.</li><li>Performance-based bonuses and incentives.</li><li>Flexible and supportive work environment.</li><li>Opportunities to work on challenging projects with modern technologies.</li><li>Career growth and skill development opportunities.</li></ul><p><br></p>','Gairidhara, Kathmandu',70000.00,90000.00,'2025-10-08 07:07:17',1,4,'2025-10-11','Bachelor in Computer Science','Full time','Mid','active',1,NULL),(21,'Project Manager','<p><span class=\"ql-size-large\">This is description</span></p><ul><li>this is line</li></ul>','Gairidhara, Kathmandu',70000.00,90000.00,'2025-10-08 14:40:36',1,8,'2025-10-11','Bachelor in Computer Science','Full time','Entry','active',1,NULL),(22,'Node.js Developer','<p>This is the description</p>','Bungamati, Lalitpur',10000.00,20000.00,'2025-10-08 14:48:21',2,8,'2025-10-12','Bachelors in IT or related field','Part time','Junior','active',1,NULL),(23,'Node.js Developer','<p>This is the description</p>','Bungamati, Lalitpur',10000.00,20000.00,'2025-10-08 14:49:04',2,8,'2025-10-12','Bachelors in IT or related field','Part time','Junior','active',1,NULL),(24,'Devops Engineer','<h2><span class=\"ql-size-large\">Job Description</span></h2><ul><li>Design, develop, and maintain high-volume, low-latency applications and systems, ensuring high availability and performance.</li><li>Contribute to all phases of the development lifecycle, including requirements analysis, testing, and deployment.</li><li>Write well-designed, testable, and efficient code using <strong>Java</strong> and related frameworks (e.g., Spring Boot, Hibernate).</li><li>Collaborate with cross-functional teams to define, design, and ship new features.</li><li>Ensure application stability through continuous integration, code reviews, and automated testing.</li><li>Participate in architectural discussions and suggest improvements to existing infrastructure and processes.</li><li>Troubleshoot, debug, and upgrade existing systems to resolve issues and enhance functionality.</li></ul><h2><span class=\"ql-size-large\">Job Specification</span></h2><ul><li>Bachelor’s degree in Computer Science, Software Engineering, or a related technical field.</li><li>Proven professional experience as a <strong>Java Developer</strong> (1–3 years preferred).</li><li>Solid understanding of object-oriented programming (OOP) principles and design patterns.</li><li>In-depth knowledge of the <strong>Java ecosystem</strong> and its core libraries, including Java 8+.</li><li>Experience with <strong>Spring Framework</strong> (Spring Boot, Spring MVC, Spring Data) is essential.</li><li>Proficiency in database technologies (SQL, NoSQL, e.g., PostgreSQL, MongoDB) and ORM tools (e.g., Hibernate, JPA).</li><li>Experience with <strong>RESTful APIs</strong>, microservices architecture, and cloud platforms (e.g., AWS, Azure) is a strong plus.</li><li>Familiarity with version control systems (Git) and Agile development methodologies (Scrum).</li></ul><h2><span class=\"ql-size-large\">What We Offer</span></h2><ul><li>Competitive salary based on skills and experience.</li><li>Performance-based bonuses and incentives.</li><li>Flexible and supportive work environment.</li><li>Opportunities to work on cutting-edge <strong>modern technologies</strong> and challenging enterprise-level projects.</li><li>Dedicated budget for professional development, certifications, and skill growth.</li></ul><p><br></p>','Lagankhel, Lalitpur',100000.00,1500000.00,'2025-10-13 15:22:28',2,5,'2025-10-04','Bachelors in IT or related field','Full time','Mid','active',1,NULL),(25,'Sales Manager','<h2><span class=\"ql-size-large\">Job Description</span></h2>\n<ul>\n  <li>Lead, motivate, and manage the sales team to achieve revenue targets and business objectives.</li>\n  <li>Develop and execute effective sales strategies to expand market reach and grow the customer base.</li>\n  <li>Identify potential clients, build strong relationships, and secure new business opportunities.</li>\n  <li>Analyze market trends, customer needs, and competitor activities to refine sales plans.</li>\n  <li>Prepare sales forecasts, pipelines, and performance reports for management review.</li>\n  <li>Collaborate with marketing, product, and operations teams to align strategies and improve customer experience.</li>\n  <li>Conduct regular team training sessions, performance evaluations, and coaching to enhance sales efficiency.</li>\n  <li>Negotiate contracts and close deals while maintaining strong customer satisfaction.</li>\n</ul>\n\n<h2><span class=\"ql-size-large\">Job Specification</span></h2>\n<ul>\n  <li>Bachelor’s degree in Business Administration, Marketing, Management, or a related field.</li>\n  <li>Proven experience as a <strong>Sales Manager</strong> or in a similar leadership role (2–5 years preferred).</li>\n  <li>Strong understanding of sales principles, negotiation tactics, and pipeline management.</li>\n  <li>Excellent leadership, communication, and interpersonal skills.</li>\n  <li>Ability to build rapport and maintain long-term customer relationships.</li>\n  <li>Experience working with CRM tools and sales reporting software.</li>\n  <li>Goal-driven, strategic thinker with strong problem-solving abilities.</li>\n  <li>Familiarity with market research and sales forecasting techniques.</li>\n</ul>\n\n<h2><span class=\"ql-size-large\">What We Offer</span></h2>\n<ul>\n  <li>Attractive salary packages with performance-based bonuses and commissions.</li>\n  <li>Supportive and collaborative work culture.</li>\n  <li>Opportunities for growth, leadership development, and career advancement.</li>\n  <li>Training programs and resources to enhance professional sales skills.</li>\n  <li>Exposure to dynamic markets and high-value client networks.</li>\n</ul>\n','Lalitpur, Nepal',50000.00,80000.00,'2025-10-26 09:30:18',1,3,'2025-12-31','Masters','Part time','Senior','active',1,NULL),(26,'Primary Teacher','<p><strong class=\"ql-size-large\">Key Responsibilities:</strong></p><ul><li>Plan, prepare, and deliver engaging lessons aligned with the curriculum for primary-level students.</li><li>Foster a positive and inclusive classroom environment that encourages participation, creativity, and critical thinking.</li><li>Assess and monitor students’ progress, providing constructive feedback to students and parents.</li><li>Maintain accurate records of student attendance, performance, and behavior.</li><li>Collaborate with colleagues to develop teaching materials, lesson plans, and school activities.</li><li>Organize and participate in school events, extracurricular activities, and parent-teacher meetings.</li><li>Promote good discipline, positive behavior, and moral values among students.</li><li>Stay updated with the latest teaching strategies, educational tools, and child development practices.</li></ul><p><strong class=\"ql-size-large\">Qualifications &amp; Skills:</strong></p><ul><li>Bachelor’s degree in Education or a related field.</li><li>Teaching certification/license (as required by local regulations).</li><li>Excellent communication, organizational, and interpersonal skills.</li><li>Patience, creativity, and a passion for working with children.</li><li>Ability to adapt teaching methods to meet the diverse needs of students.</li></ul><p><strong class=\"ql-size-large\">Preferred:</strong></p><ul><li>Experience teaching primary-level students.</li><li>Familiarity with digital teaching tools and educational technology.</li></ul><p><br></p>','Pulchowk, Lalitpur',30000.00,50000.00,'2025-10-29 16:15:00',4,6,'2025-10-30','+2 Completed','Full time','Senior','active',1,NULL),(27,'QA Engineer','<h2><span class=\"ql-size-large\" style=\"color: rgb(13, 110, 253);\">Key Responsibilities:</span></h2><ul><li>Plan, prepare, and deliver engaging lessons aligned with the curriculum for primary-level students.</li><li>Foster a positive and inclusive classroom environment that encourages participation, creativity, and critical thinking.</li><li>Assess and monitor students’ progress, providing constructive feedback to students and parents.</li><li>Maintain accurate records of student attendance, performance, and behavior.</li><li>Collaborate with colleagues to develop teaching materials, lesson plans, and school activities.</li><li>Organize and participate in school events, extracurricular activities, and parent-teacher meetings.</li><li>Promote good discipline, positive behavior, and moral values among students.</li><li>Stay updated with the latest teaching strategies, educational tools, and child development practices.</li></ul><h2><span class=\"ql-size-large\" style=\"color: rgb(13, 110, 253);\">Qualifications &amp; Skills:</span></h2><ul><li>Bachelor’s degree in Education or a related field.</li><li>Teaching certification/license (as required by local regulations).</li><li>Excellent communication, organizational, and interpersonal skills.</li><li>Patience, creativity, and a passion for working with children.</li><li>Ability to adapt teaching methods to meet the diverse needs of students.</li></ul><h2><span class=\"ql-size-large\" style=\"color: rgb(13, 110, 253);\">Preferred:</span></h2><ul><li>Experience teaching primary-level students.</li><li>Familiarity with digital teaching tools and educational technology.</li></ul><p><br></p>','Gairidhara, Kathmandu',30000.00,50000.00,'2025-11-12 03:40:27',1,6,'2025-11-15','Bachelor in Computer Science','Full time','Mid','active',1,''),(28,'Customer Handler','Key Responsibilities:Serve as the first point of contact for customers, addressing inquiries, concerns, and requests promptly and professionally.Build and maintain strong relationships with customers to ensure satisfaction and loyalty.Handle customer complaints and issues effectively, providing appropriate solutions or escalating when necessary.Maintain accurate records of customer interactions, transactions, and feedback.Collaborate with team members and other departments to improve customer service processes and experiences.Provide product or service information and guidance to customers as needed.Follow company policies and procedures to ensure high-quality service delivery.Stay updated on company products, services, and customer service best practices.Qualifications &amp; Skills:Bachelor’s degree or equivalent experience in Business, Communication, or a related field.Excellent communication, problem-solving, and interpersonal skills.Strong patience, empathy, and ability to handle difficult situations calmly.Ability to multitask and adapt to changing customer needs and priorities.Preferred:Prior experience in customer service or a client-facing role.Familiarity with customer relationship management (CRM) tools and software.Knowledge of the company’s products or services.','Pulchowk, Lalitpur',10000.00,20000.00,'2025-12-05 14:17:17',1,2,'2025-12-13','Bachelors in Arts or related field hehe','Full time','Entry','active',2,'customer_service'),(29,'Cyber Security','<p><strong class=\"ql-size-large\">Key Responsibilities:</strong></p><ul><li>Serve as the primary point of contact for clients regarding cybersecurity inquiries, incidents, or service requests.</li><li>Assist customers in understanding cybersecurity products, services, and best practices.</li><li>Handle cybersecurity-related issues, such as access problems, security alerts, or breach concerns, escalating to technical teams when necessary.</li><li>Maintain accurate records of customer interactions, security incidents, and resolutions.</li><li>Collaborate with internal cybersecurity and IT teams to improve security processes and client experiences.</li><li>Provide guidance on safe digital practices, threat prevention, and compliance requirements.</li><li>Follow company policies and procedures to ensure secure and professional service delivery.</li><li>Stay updated on cybersecurity trends, tools, and client security needs.</li></ul><p><strong class=\"ql-size-large\">Qualifications &amp; Skills:</strong></p><ul><li>Bachelor’s degree in Cybersecurity, Information Technology, or a related field (or equivalent experience).</li><li>Excellent communication, problem-solving, and interpersonal skills.</li><li>Strong patience, empathy, and ability to handle sensitive security situations calmly.</li><li>Ability to multitask and adapt to changing client security needs and priorities.</li></ul><p><strong class=\"ql-size-large\">Preferred:</strong></p><ul><li>Prior experience in customer service or client-facing roles in a cybersecurity or IT environment.</li><li>Familiarity with cybersecurity tools, incident response processes, and CRM software.</li><li>Knowledge of cybersecurity principles, threats, and best practices.</li></ul><p><br></p>','Gairidhara, Kathmandu',70000.00,90000.00,'2025-12-05 15:17:40',2,4,'2025-12-06','Bachelors in IT or related field','Full time','Mid','active',3,'it_software'),(30,'JAVA Developer','<h2><span class=\"ql-size-large\">Key Responsibilities:</span></h2><ul><li>Serve as the primary point of contact for development-related tasks, project updates, and technical queries from clients or internal teams.</li><li>Design, develop, and maintain Java-based applications, ensuring high performance, scalability, and security.</li><li>Troubleshoot, debug, and resolve software defects or performance issues in a timely manner.</li><li>Collaborate with cross-functional teams, including QA, UI/UX, and DevOps, to deliver high-quality solutions.</li><li>Participate in code reviews, provide constructive feedback, and maintain coding standards.</li><li>Document technical specifications, processes, and project updates clearly for team and client reference.</li><li>Stay updated on Java technologies, frameworks, and industry best practices to recommend improvements.</li></ul><h2><span class=\"ql-size-large\">Qualifications &amp; Skills:</span></h2><ul><li>Bachelor’s degree in Computer Science, Software Engineering, or a related field (or equivalent experience).</li><li>Strong proficiency in Java programming and object-oriented design principles.</li><li>Familiarity with Java frameworks such as Spring, Hibernate, or Java EE.</li><li>Excellent problem-solving, analytical, and debugging skills.</li><li>Good communication and interpersonal skills to collaborate with team members and clients effectively.</li><li>Ability to manage multiple tasks and adapt to evolving project requirements.</li></ul><h2><span class=\"ql-size-large\">Preferred:</span></h2><ul><li>Prior experience in client-facing or collaborative software development projects.</li><li>Knowledge of RESTful APIs, microservices architecture, and database management (SQL/NoSQL).</li><li>Familiarity with version control systems (e.g., Git) and agile development practices.</li><li>Awareness of software security best practices and performance optimization techniques.</li></ul><p><br></p>','Pulchowk, Lalitpur',70000.00,90000.00,'2025-12-09 15:30:47',1,2,'2025-12-13','Bachelor in Computer Science','Full time','Mid','active',1,'it_software'),(31,'Frontend Developer','<p>This is the description</p>','Pulchowk, Lalitpur',10000.00,20000.00,'2025-12-10 05:19:30',1,2,'2025-12-11','Bachelor in Computer Science','Full time','Mid','active',5,'it_software');
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) NOT NULL,
  `address` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (6,'Mary Moe','Bungamati, Lalitpur','mary@gmail.com','$2y$10$PUjCvwkLfxOVfNn7R.klOuK9lq0ziX5Yz8VTWXRl1cFJZjWl2sLS6','1762700346_mary.png','1762700346_OutputNM.docx','2025-11-09 14:59:06'),(7,'John Doe','Kathmandu, Nepal','john.doe@example.com','$2y$10$6c3EonQSZoPNL3yv145xeOD7lU20mGNq1bPgJJTdUdD2rzBvzRf1a','john.jpg','john_resume.pdf','2025-11-09 15:02:32'),(8,'Sarun Shakya','Bungamati, Lalitpur','sarunshakya414@gmail.com','$2y$10$TBGOVZvUMVd7CgrP2Eg5geEzsb/8oojYF1ohwwtJHaw9yB1xNfBr.','1762701365_Screenshot 2025-03-25 160645.png','1762701365_Sarun Shakya.pdf','2025-11-09 15:16:05'),(9,'Harry Nolan','California','harry@gmail.com','$2y$10$cPW3V1hWYKR80sjKpAMb/.nGuEo0hTJJ8hGmO/mQw6kOxsLJ9E43y','1763286778_harry.png','1763286778_ABSTRACT.pdf','2025-11-16 09:52:59'),(10,'samir shakya','lalitpur','sameershakya999@gmail.com','$2y$10$REXRVMUwJCeSqQacy3RcBu9l9Bsu4JeFZRjLXB2heGCBqLobHqRMS',NULL,NULL,'2025-11-22 14:43:21'),(11,'Suresh Shrestha','Lalitpur, Nepal','suresh@gmail.com','$2y$10$p3k4MPjyAE0sjLZIccfODeQw9pm.CcbGvQR.ipJkC/3mNuek7EMVC','1764945720_harry.png','1764945720_ABSTRACT.pdf','2025-12-05 14:42:00'),(12,'Gopal Adhikari','Kupondole, Lalitpur','gopal@gmail.com','$2y$10$XcJzxvq46yxA4WmZ8u7qHOlzh5OVMxOpwE.SbMqas5LJBJy/1V4NS',NULL,'1765294323_resume-sample.pdf','2025-12-09 15:32:03');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-11 14:59:43
