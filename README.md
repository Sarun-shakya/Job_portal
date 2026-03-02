# 💼 Job Portal Web Application

A dynamic and fully functional **Job Portal System** built using PHP and MySQL that connects job seekers with employers. This platform allows users to register, browse jobs, apply, and manage postings efficiently.

🔗 **Live Demo:** https://jobportal.sarunshakya.com.np/  
🔗 **GitHub Repository:** https://github.com/Sarun-shakya/job-portal  

---

## 🚀 Features

### 👤 User Features
- User Registration & Login
- Secure Authentication with Sessions
- Browse Available Jobs
- View Detailed Job Descriptions
- Apply for Jobs
- Save/Bookmark Jobs
- Manage User Profile
- Resume upload & management

### 🏢 Employer Features
- Post New Jobs
- Edit & Delete Job Listings
- Manage Applications
- Dashboard Overview
- Profile Management

### 🛠️ Admin Features
- User Management
- Employer Management
- Job Management
- Dashboard Overview

---

## 🛠️ Tech Stack

- **Frontend:** HTML, CSS, JavaScript, Bootstrap  
- **Backend:** PHP  
- **Database:** MySQL  
- **Version Control:** Git & GitHub  
- **Deployment:** Hosted on Live Server  

---

## 📂 Project Structure

```
job-portal/
│
├── admin/              # Admin dashboard & job management
├── assets/             # Images
├── config/             # Database configuration
├── includes/           # Reusable components
├── uploads/            # User uploaded files
├── sql/                # Database schema
├── index.php           # Homepage
├── login.php           # Login page
├── register.php        # Registration page
      
```

---

## ⚙️ Installation & Setup

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/Sarun-shakya/job-portal.git
```

### 2️⃣ Move to Project Directory
```bash
cd job-portal
```

### 3️⃣ Setup Database
- Create a new database in MySQL (e.g., `job_portal`)
- Import the provided `job_portal.sql` file
- Update database credentials inside:

```
config/db.php
```

Example:
```php
$host = "localhost";
$user = "root";
$password = "";
$database = "job_portal";
```

### 4️⃣ Run the Project
- Start Apache & MySQL (XAMPP/WAMP)
- Place the project inside `htdocs`
- Open in browser:

```
http://localhost/job-portal/
```

---

## 📊 Database Design

The system uses a relational database structure including:
- Users Table
- Jobs Table
- Applications Table
- Bookmarks Table
- Admin Table
- Employers Table

---

## 🔐 Security Implementations

- Password hashing
- Session-based authentication
- Input validation
- SQL injection prevention (Prepared Statements)


---

## 📚 Key Learnings

- Building full-stack web applications
- Implementing CRUD operations
- Designing relational database schemas
- Managing authentication & sessions
- Handling form validation (frontend + backend)
- Structuring real-world web projects
- Deploying live applications

---

## 🎯 Future Improvements

- Email notifications for job applications
- Advanced job filtering & search
- Role-based dashboards
- Improved UI/UX design

---

## 🤝 Contributing

Contributions, suggestions, and feedback are welcome!  
Feel free to fork the repository and submit a pull request.

---

## 📧 Contact

**Sarun Shakya**  
GitHub: https://github.com/Sarun-shakya  
LinkedIn: https://www.linkedin.com/in/sarun-shakya-91110b2b3/

---

⭐ If you found this project helpful, consider giving it a star!
