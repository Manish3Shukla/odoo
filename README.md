# odoo


# 👗 ReWear – Community Clothing Exchange

ReWear is a full-stack web application that promotes sustainable fashion by enabling users to exchange unused clothing. Users can list items, request swaps, or redeem clothes using a point-based system. Admins can moderate listings, and email notifications ensure communication during swaps.

---

## 🌐 Live Demo

> *(Optional)* Add link here if deployed

---

## 🚀 Features

### 👤 User
- Email/password authentication
- Browse available clothing items
- Upload new items with images and tags
- Request item via swap or points
- View dashboard with profile, items, and swap history

### 📦 Item System
- Add detailed listings (size, condition, category)
- Image uploads with gallery display
- Item status (available / swapped)
- Swap requests and point redemption

### 🔁 Swap Mechanism
- Users can request items
- Owners approve/decline swaps
- Automatic point deduction on redemption
- Email notifications sent for approvals/declines

### 🛠 Admin Panel
- Approve or reject item listings
- Remove inappropriate content
- Lightweight UI for moderation

### 🔔 Notifications
- Email alerts for swap approvals/declines

---

## 🧰 Tech Stack

| Layer         | Technology               |
|---------------|---------------------------|
| Frontend      | HTML, CSS, JavaScript     |
| Backend       | PHP (Core PHP)            |
| Database      | MySQL                     |
| Email         | PHP `mail()` or PHPMailer |
| Animation     | CSS Transitions, Carousel |

---

## 📁 Project Structure

rewear/
│
├── index.php # Landing Page
├── login.php # User Login
├── register.php # User Signup
├── dashboard.php # User Dashboard
├── add_item.php # Add new clothing item
├── item_detail.php # View item details
│
├── user/
│ ├── swap_requests.php # Swap approval UI
│ └── swap_action.php # Handle swap logic
│
├── admin/
│ ├── index.php # Admin panel UI
│ └── item_action.php # Approve/reject items
│
├── includes/
│ ├── db.php # Database connection
│ └── auth.php # Session/role check
│
├── uploads/ # Uploaded images
├── assets/
│ ├── css/style.css # Main styles
│ └── js/scripts.js # Optional interactivity
│
└── README.md

## ⚙️ Setup Instructions

1. **Clone the repo**
   ```bash
   git clone https://github.com/yourusername/rewear.git
   cd rewear
Import MySQL Database

Use phpMyAdmin or MySQL CLI

Create a database rewear

Import rewear.sql (you'll need to create one with the schema)

Configure DB Connection

Edit includes/db.php:

$conn = mysqli_connect("localhost", "root", "", "rewear");
(Optional) Enable PHPMailer for email

Install with Composer:

composer require phpmailer/phpmailer
Configure SMTP in swap_action.php

✅ To-Do / Improvements
 Responsive design for mobile users

 Search & filter (tags, size, category)

 User-to-user messaging or chat

 Admin user management

 Points transaction history

 Dark mode
