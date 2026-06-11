# GetCare / ProjecteBeauty 💄✨

A scalable, modern web application for beauty and healthcare services built with **Laravel** and **Tailwind CSS**.

## 🧠 Project Architecture Approach

This project follows a **scalable and maintainable architecture pattern** to ensure clean code separation and long-term flexibility.

We use a layered structure:

* **Controllers** → Handle HTTP requests only (thin controllers, no business logic).
* **Services** → Contain all business logic and application rules.
* **Repositories** → Handle database queries and data access layer.
* **Models** → Represent database structure and relationships.
* **Form Requests** → Handle validation logic separately from controllers.
* **DTOs (optional)** → Transfer structured data between layers.

### 🔄 Application Flow

```
Request → Controller → Service → Repository → Model → Database
Response ← Resource / DTO ← Service ← Controller
```

### 📁 Code Organization Principle

* Keep controllers minimal and clean.
* Move logic to services (business layer).
* Use repositories for all DB operations.
* Use dependency injection for better testability.
* Maintain reusable and modular code structure.

### 🚀 Frontend Structure Approach

Frontend is organized into:

* **Layouts (`resources/views/layouts/`)** → Base structure (e.g., `app.blade.php`).
* **Partials (`resources/views/partials/`)** → Included components (e.g., `header.blade.php`, `footer.blade.php`).
  * **Header Topbar:** Includes global utilities like the Country/Currency Selector, Auth links (Sign In/Sign Up), Account actions, and Cart options. Located in `partials/header.blade.php`.
* **Pages (`resources/views/pages/`)** → Full views/screens.
* **Components** → Reusable UI blocks.

## 🌟 Features

* **Top Utility Bar:** Fully responsive, sticky top bar providing users with multi-currency & country selection, account management (Sign In/Up), search functionality, and shopping cart overview.
* **Modern UI:** Tailwind CSS for beautiful, responsive design components.
* **Service Booking:** Browse and book premium beauty and healthcare services seamlessly.

## ⚙️ Coding Standard Rule

All development must follow:

* Clean Architecture principles
* SOLID principles
* PSR-12 coding standard
* Separation of concerns
* No business logic inside controllers or views
