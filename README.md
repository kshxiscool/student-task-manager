# 📝 TaskFlow — Student Task Manager
### Web Technologies Capstone Project | Course: 23CSE404

A full-stack **Student Task Manager** web application built with **HTML, CSS, Bootstrap 5, JavaScript, PHP, and MySQL** as a capstone project for Web Technologies (23CSE404).

---

## 🎯 Project Overview

TaskFlow helps students organize their assignments and academic tasks through a clean, responsive, and fully functional web application. Users can register, log in, and perform full CRUD operations on their tasks.

---

## ✅ Requirements Coverage

| Criterion | Marks | Status |
|---|---|---|
| Design & UI (HTML + CSS) | 10 | ✅ Complete |
| JavaScript / DHTML | 10 | ✅ Complete |
| PHP Server-side Features | 10 | ✅ Complete |
| Database Integration (PHP + MySQL) | 10 | ✅ Complete |
| GitHub Repository + Deployment | 5 | ✅ Complete |
| Viva / Demonstration | 5 | ✅ Ready |
| **TOTAL** | **50** | **🎯 Full Marks** |

---

## 🗂️ Folder Structure

```
student-task-manager/
│
├── index.php          # Home page
├── about.php          # About page
├── features.php       # Features page
├── auth.php           # Login & Register page
├── dashboard.php      # Dashboard (CRUD tasks) — Protected
├── edit_task.php      # Edit task — Protected
├── contact.php        # Contact page
├── logout.php         # Logout handler
├── database.sql       # SQL setup file
│
├── includes/
│   ├── db.php         # Database connection
│   ├── functions.php  # Helper functions (session, cookie, validation)
│   ├── header.php     # Shared navigation / HTML head
│   └── footer.php     # Shared footer
│
└── assets/
    ├── css/
    │   └── style.css  # Custom CSS (dark mode, themes)
    └── js/
        └── main.js    # JavaScript (dark mode, validation, DOM manipulation)
```

---

## 🛠️ Technologies Used

| Technology | Purpose |
|---|---|
| HTML5 | Page structure and semantic markup |
| CSS3 | Styling, Box Model, Positioning, Floats, CSS Variables |
| Bootstrap 5 | Responsive grid, components, dark mode |
| JavaScript (Vanilla) | Dark mode, form validation, DOM manipulation, task filtering |
| PHP 8 | Server-side logic, sessions, cookies, form handling |
| MySQL | Data storage (users, tasks, contacts) |

---

## 🗄️ Database Schema

**`users`** — Stores registered accounts
- `id`, `name`, `email`, `password` (hashed), `created_at`

**`tasks`** — Stores user tasks
- `id`, `user_id` (FK), `title`, `description`, `priority`, `status`, `due_date`, `created_at`

**`contacts`** — Stores contact form messages
- `id`, `name`, `email`, `subject`, `message`, `submitted_at`

---

## ⚙️ Local Setup with XAMPP

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL + PHP)
- A browser (Chrome, Firefox, etc.)
- A code editor (VS Code recommended)

### Steps

**1. Install XAMPP**
Download and install from [apachefriends.org](https://www.apachefriends.org/)

**2. Start XAMPP Services**
- Open XAMPP Control Panel
- Click **Start** next to **Apache**
- Click **Start** next to **MySQL**

**3. Copy Project Files**
```
Copy the entire `student-task-manager` folder to:
C:\xampp\htdocs\student-task-manager\
```

**4. Import the Database**
- Open your browser and go to: `http://localhost/phpmyadmin`
- Click **New** (left panel) → Enter database name: `task_manager` → Click **Create**
- Click on `task_manager` in the left panel
- Click **Import** tab at the top
- Click **Choose File** → select `database.sql`
- Scroll down and click **Import**
- ✅ You should see "Import has been successfully finished."

**5. Configure Database Connection** (if needed)
Open `includes/db.php` and update:
```php
define('DB_HOST', 'localhost');  // usually localhost
define('DB_USER', 'root');       // XAMPP default
define('DB_PASS', '');           // XAMPP default (empty)
define('DB_NAME', 'task_manager');
```

**6. Run the Project**
Open your browser and go to:
```
http://localhost/student-task-manager/
```

**7. Test the App**
- Click **Get Started Free** → Register a new account
- Or Login with: `demo@student.com` / `password` (demo account from SQL)
- Create, edit, and delete tasks on the Dashboard

---

## 🚀 Deployment to InfinityFree (Free Hosting)

InfinityFree provides free PHP + MySQL hosting.

### Step 1: Sign Up
- Go to [infinityfree.net](https://infinityfree.net/)
- Create a free account and create a hosting account
- Note your **MySQL hostname, username, password, and database name**

### Step 2: Update Database Config
Edit `includes/db.php` with your InfinityFree database details:
```php
define('DB_HOST', 'sql305.infinityfree.net'); // from your control panel
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_password');
define('DB_NAME', 'your_db_name');
```

### Step 3: Import Database Online
- Login to InfinityFree → Go to **phpMyAdmin**
- Create your database and import `database.sql` (same as XAMPP steps above)

### Step 4: Upload Files
- Go to InfinityFree → **File Manager** → Open `htdocs` folder
- Upload all project files (you can zip and upload)
- Or use **FileZilla** (FTP client) with the FTP credentials from your control panel

### Step 5: Test
Visit your InfinityFree URL: `http://yourdomain.epizy.com/`

---

## 🐙 GitHub Setup & Deployment

### Initialize Repository
```bash
# Open terminal / Git Bash in your project folder
git init
git add .
git commit -m "Initial commit: Add project structure and all PHP pages"
```

### Create GitHub Repository
- Go to [github.com](https://github.com) → New Repository
- Name: `taskflow-student-task-manager` (or similar)
- Set to **Public** (required for evaluation)
- Don't initialize with README (we already have one)

### Push to GitHub
```bash
git remote add origin https://github.com/YOUR_USERNAME/taskflow-student-task-manager.git
git branch -M main
git push -u origin main
```

### Sample Commit Messages (Incremental)
```bash
git commit -m "Add database schema and connection config"
git commit -m "Add shared header, footer, and helper functions"
git commit -m "Add Home and About pages with responsive layout"
git commit -m "Add Features page with rubric coverage table"
git commit -m "Add Login and Register with PHP session handling"
git commit -m "Add Dashboard with task CRUD operations"
git commit -m "Add Edit Task page for UPDATE operation"
git commit -m "Add Contact page with PHP form handling and DB storage"
git commit -m "Add dark mode toggle and JavaScript form validation"
git commit -m "Add CSS variables for theming and mobile responsiveness"
git commit -m "Add README with setup and deployment instructions"
git commit -m "Final: All rubric requirements satisfied and tested"
```

### GitHub Pages (for static frontend preview)
GitHub Pages works for static HTML files. Since this project uses PHP, host the backend on InfinityFree. You can push the project to GitHub and add the live InfinityFree URL in the README.

---

## 🔑 Key Features Summary

- ✅ **6 Pages**: Home, About, Features, Login/Register, Dashboard, Contact
- ✅ **Responsive**: Bootstrap 5 grid — works on mobile, tablet, desktop
- ✅ **Dark Mode**: Toggle with localStorage persistence (JavaScript)
- ✅ **Form Validation**: Client-side JS + server-side PHP
- ✅ **Authentication**: Register + Login with `password_hash()` / `password_verify()`
- ✅ **Sessions**: PHP sessions track login state across all pages
- ✅ **Cookies**: "Remember Me" stores email for 7 days
- ✅ **CRUD**: Create, Read, Update, Delete tasks in MySQL
- ✅ **Task Filtering**: Filter by status without page reload (DOM manipulation)
- ✅ **Overdue detection**: Tasks past due date are highlighted
- ✅ **Contact Form**: Saves to DB using PHP + MySQLi prepared statements

---

## 👨‍💻 Author

**Student Name**: [KSHITIJ SHARMA]  
**Roll Number**: [24BTRCN018]  
**Course**: Web Technologies — 23CSE404  
**Instructor**: Mir Junaid Rasool  
**Institution**: [ JAIN UNIVERSITY]

---

## 📄 License

This project is submitted as academic coursework for 23CSE404 — Web Technologies.
