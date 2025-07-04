# E-commerce Project

---

## 📦 Project Overview

A multi-vendor e-commerce website where:

✅ Customers browse and purchase products.  
✅ Sellers manage their own product catalog.  
✅ Admins manage users, products, and site data.

---

## ✅ Tech Stack

- **Frontend:**
  - HTML
  - CSS
  - JavaScript (Vue.js planned)

- **Backend:**
  - PHP (Vanilla)

- **Database:**
  - MariaDB (via phpMyAdmin)

- **Server:**
  - Apache (XAMPP on Linux)

---

## ✅ Folder Structure

```
ecommerce-project/
│
├── admin/
│   └── dashboard.php
│
├── assets/
│   └── style.css
│
├── backend/
│
├── customer/
│   └── dashboard.php
│
├── includes/
│   └── db_connect.php
│
├── public/
│   ├── add_product.php
│   ├── login.php
│   ├── logout.php
│   ├── products.php
│   └── register.php
│
├── seller/
│   └── dashboard.php
│
├── sql/
│
└── README.md
```

---

## ✅ Folder Purposes

- **admin/** → Admin dashboards and management tools.
- **assets/** → CSS and JS files.
- **backend/** → Reserved for backend logic/APIs (future).
- **customer/** → Customer-specific dashboards/pages.
- **includes/** → Reusable PHP files like DB connection.
- **public/** → Entry points for pages like login, register, products.
- **seller/** → Seller dashboards and product management pages.
- **sql/** → SQL scripts for table creation and data dumps.

---

## ✅ Database Schema

### `users`

| Column        | Type            | Description               |
|---------------|-----------------|---------------------------|
| id            | INT, PK, AI     | Unique user ID            |
| username      | VARCHAR         | Display name              |
| email         | VARCHAR         | User email address        |
| password_hash | VARCHAR         | Hashed password           |
| role          | ENUM            | admin, seller, customer   |
| created_at    | TIMESTAMP       | When user was created     |

---

### `products`

| Column       | Type              | Description                    |
|--------------|-------------------|--------------------------------|
| id           | INT, PK, AI       | Unique product ID              |
| name         | VARCHAR           | Product name                   |
| image        | VARCHAR           | Filename for product image     |
| description  | TEXT              | Product description            |
| price        | DECIMAL           | Product price                  |
| stock        | INT               | Quantity in stock              |
| category_id  | INT (nullable)    | Future category linkage        |
| seller_id    | INT (FK → users)  | Seller who owns this product   |
| created_at   | TIMESTAMP         | Created date                   |
| updated_at   | TIMESTAMP         | Last modified date             |

---

## ✅ Roles

- **Admin**
  - Manage users
  - Manage all products

- **Seller**
  - Manage own products (CRUD)
  - View orders (future)

- **Customer**
  - Browse products
  - Place orders (future)

---

## ✅ Next Steps

✅ Build product CRUD for sellers/admins.  
✅ Implement product listing and details pages.  
✅ Integrate Vue.js for dynamic frontend.  
✅ Implement order system.

---

> This project is in progress. Stay tuned for updates!
