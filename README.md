# EduFlow ERP 🎓

EduFlow is a comprehensive, high-performance Enterprise Resource Planning (ERP) system designed specifically for modern educational institutions. 

Built entirely on the **TALL Stack** (Tailwind CSS, Alpine.js, Laravel 11, Livewire 3 / Volt), EduFlow offers a reactive, Single-Page Application (SPA) experience without the complexity of a separate JavaScript frontend. It centralizes student records, automates fee collection, manages staff payroll, and streamlines academic grading.

---

## ✨ Comprehensive Feature Modules

### 👥 1. Student Identity & Lifecycle Management
* **Student Directory & Profiles:** Complete digital dossiers including avatars, document management, and detailed academic histories.
* **Bulk Operations:** Fast-track administrative workflows with **Bulk Enrollment** and **Bulk Graduation** tools.
* **Student Portal:** Dedicated, restricted access for students to view their own grades and fee statuses.

### 💼 2. HR, Payroll & Staff Management
* **Staff Directory & Profiles:** Track employee records, contact info, and joining dates.
* **Designation Manager:** Assign default salaries and strict role-based access permissions.
* **Attendance Tracking:** Monitor daily staff availability and log digital attendance.
* **Automated Payroll Generation:** Calculate salaries, track deductions/bonuses, and generate printable `Payslips`.

### 💰 3. Financial Desktop & Accounting
* **POS-Style Fee Collection:** A lightning-fast cashier desk to collect cash and instantly print professional `Fee Vouchers`.
* **Automated Fee Engine:** Utilize the `Bulk Fee Generator` to assign monthly dues across the entire student body in seconds based on `Fee Structures`.
* **Income & Expense Tracking:** Dedicated modules to manage all incoming revenue and outgoing operational costs.
* **Financial Ledger:** Comprehensive reporting tools to audit the school's exact cash flow in real-time.

### 📝 4. Academic Dispatch & Grading
* **Curriculum Configuration:** Manage `Classes`, `Subjects`, and distinct `Exams` (terms/semesters).
* **Dynamic Marks Entry:** A fast, spreadsheet-like interface for teachers to input subject marks and toggle absentee statuses seamlessly.
* **Automated Report Cards:** Instantly generate and print structured, professional report cards for entire classes.

### ⚙️ 5. System Administration
* **Global School Settings:** Centrally manage the institution's name, logo, and active academic sessions.
* **Role-Based Access Control (RBAC):** Powered by Spatie Permissions. Strict security protocols ensure faculty, cashiers, and admins only access their authorized modules.

---

## 💻 Technical Stack

* **Core Framework:** [Laravel 11](https://laravel.com/)
* **Frontend Reactive Engine:** [Livewire 3 (Volt Class API)](https://livewire.laravel.com/)
* **Interactivity:** [Alpine.js](https://alpinejs.dev/)
* **Styling:** [Tailwind CSS](https://tailwindcss.com/)
* **Database:** MySQL / Eloquent ORM
* **Role Management:** Spatie Laravel Permission

---

## 🚀 Installation & Setup Instructions

Follow these steps to get a local development environment running:

### Prerequisites
* PHP 8.2+
* Composer
* Node.js & NPM
* MySQL or SQLite

### 1. Clone the Repository
```bash
git clone https://github.com/haidersherazi001/school-management.git
cd school-management