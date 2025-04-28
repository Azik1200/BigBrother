# BigBrother Platform

**BigBrother** is an internal control platform focused on task management, incident tracking, user group coordination, and document management. It supports role-based access control, file uploads, and Excel-based data imports.

---

## 📚 Architecture

### Core Modules

- **Authentication** — User login/logout, role-based access
- **Dashboard** — User's main page with tasks and group overview
- **Tasks** — Full task lifecycle management: create, assign, update, complete
- **NLD** — Incident management with Excel file import
- **Groups** — User groups management
- **Admin Panel** — Manage users and FollowUp checklists (admin only)
- **Procedures** — Document and procedure storage
- **Scripts** — Technical scripts and instructions storage
- **Comments** — Add comments to NLD incidents
- **Excel Upload** — Upload and parse Excel (.xlsx) files

---

### Main Entities (Models)

| Model       | Purpose                                           |
|-------------|---------------------------------------------------|
| **User**    | System user                                       |
| **Group**   | User group                                         |
| **Task**    | User-created or assigned tasks                    |
| **Role**    | User role (admin, director, user)                 |
| **Nld**     | Incidents loaded from Excel files                 |
| **Comment** | Comments attached to NLD incidents                |
| **FollowUp**| Risk assessment checklists                        |
| **Procedure**| Stored procedures and documents                 |
| **Script**  | Stored scripts and guides                        |
| **File**    | File attachments linked to tasks                  |

---

### Middleware

- **auth** — Standard authentication check
- **RoleMiddleware** — Role-based access validation

---

### Technology Stack

- Laravel 10/11
- Blade (Laravel templating engine)
- Bootstrap 5 (Frontend framework)
- Bootstrap Icons
- Maatwebsite Excel (Excel file parsing)
- MySQL (Database)

---

### Routing Overview

| Area        | Endpoint Prefix | Middleware |
|-------------|-----------------|------------|
| Public Auth | `/login`, `/excel` | - |
| Dashboard   | `/`              | auth |
| NLD         | `/nld`           | auth |
| Tasks       | `/tasks`         | auth |
| Procedures  | `/procedures`    | auth |
| Scripts     | `/script`        | auth |
| Groups      | `/groups`        | auth / role:admin |
| Admin Panel | `/admin`         | auth + role:admin |

---

### Future Enhancements (Planned)

- Introduce **Service Layer** (e.g., `FileUploadService`, `NldImportService`)
- Expand **Notification System** (e.g., for task assignments)
- Implement **SoftDeletes** for critical models (User, Task, Group)
- Add **Activity Logs** for Admin actions
- Integrate **Task Calendar View** (weekly/monthly visualization)

---

## 📋 Project Folder Structure

routes/ web.php

app/ Http/ Controllers/ Middleware/ Models/ Mail/ Services/ (planned)

resources/ views/ auth/ dashboard/ tasks/ nld/ groups/ admin/ followup/ procedures/ scripts/

database/ migrations/ seeders/ factories/

---

# 🛡️ Access Levels

| Role    | Permissions                                               |
|---------|------------------------------------------------------------|
| **Admin** | Full access (users, groups, tasks, procedures, followups) |
| **Director** | Task and FollowUp access                              |
| **User** | Tasks, groups, NLD, scripts, comments                     |

---

# 🚀 Quick Start

1. Clone the repository
2. Configure `.env` for database and mail settings
3. Run migrations: `php artisan migrate`
4. (Optional) Seed initial roles: `php artisan db:seed`
5. Start development server: `php artisan serve`

---

# 📩 Contact

Project Lead: **Aziz Salimli** and **Cavid Musayev**

---

