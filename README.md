# Blogify: A Dynamic Simple Blogging Platform

Blogify is a feature-rich, modern blogging platform built with PHP and MySQL. It provides a complete solution for creating, managing, and sharing content, with features designed for both writers and readers.

**Live Demo**: [http://blogify.myartsonline.com](http://blogify.myartsonline.com)

## ✨ Features

-   **User Authentication**: Secure registration and login system for users.
-   **User Dashboard**: A personalized dashboard for each user to manage their posts.
-   **Post Management (CRUD)**: Users can create, read, update, and delete their blog posts.
-   **Featured Post**: The homepage automatically showcases the most viewed post to highlight popular content.
-   **Commenting System**: Allows readers to engage in discussions on posts. Comments can be moderated.
-   **Pagination**: Clean and intuitive pagination for browsing through a large collection of posts.
-   **View Counter**: Tracks and displays the number of views for each post.
-   **Responsive Design**: A clean, modern, and responsive user interface that looks great on all devices.
-   **Dynamic Content**: Content, including posts and comments, is dynamically loaded from the database.

## 🛠️ Technology Stack

-   **Backend**: PHP
-   **Database**: MySQL
-   **Frontend**: HTML, CSS, JavaScript
-   **Icons**: Font Awesome

## 📂 Project Structure

The project is organized with a clear separation of concerns, placing core logic, assets, and view components in distinct files and directories.

```
/blogsystem
├── admin/
│   ├── header.php          # Admin site header, navigation, session management
│   ├── footer.php          # Admin site footer and script includes
│   ├── index.php           # Admin dashboard home
│   ├── dashboard.php       # Admin dashboard - manage posts
│   ├── login.php           # Admin login page
│   ├── logout.php          # Admin logout handler
│   ├── create-post.php     # Admin create new blog post form
│   └── edit-post.php       # Admin edit any post
├── config/
│   └── db.php              # Database connection & helper functions
├── database/
│   └── blog_system.sql      # SQL dump for database setup
├── assets/
│   ├── css/
│   │   └── style.css       # Main stylesheet (shared between user & admin)
│   ├── js/
│   │   └── main.js         # Custom JavaScript (shared between user & admin)
├── header.php              # User site header, navigation, session management
├── footer.php              # User site footer and script includes
├── index.php               # Homepage - latest & featured posts
├── post.php                # Single post display & comments
├── dashboard.php           # User dashboard - manage own posts
├── create-post.php         # User create new blog post form
├── edit-post.php           # User edit own post
├── login.php               # User login page
├── register.php            # User registration page
├── logout.php              # User logout handler
└── README.md
```
## 🗃️ Database Schema

The project uses a relational database to manage its data, centered around three core tables:

-   `users`: Manages user accounts, including credentials and profile information.
-   `posts`: Stores all blog articles, with fields for title, content, slug, status (`draft`, `published`), and view count.
-   `comments`: Contains comments made by users on posts, linked by `post_id` and including an approval `status`.

The `database/blog_system.sql` file contains the necessary SQL commands to create these tables and their relationships.

## ⚙️ Core Components

### User Section

-   **`index.php`**: Homepage with hero section, featured post, and paginated latest posts
-   **`post.php`**: Single post view with full content, metadata, and comments
-   **`dashboard.php`**: User dashboard for managing their own posts
-   **`create-post.php`**: Form to create new blog posts
-   **`edit-post.php`**: Form to edit user's own posts
-   **`login.php`** / **`register.php`**: User authentication pages
-   **`header.php`** / **`footer.php`**: Shared layout components

### Admin Section

-   **`dashboard.php`**: Manage all posts on platform
-   **`create-post.php`**: Admin create post form
-   **`edit-post.php`**: Admin edit any post
-   **`login.php`**: Admin authentication
-   **`header.php`** / **`admin/footer.php`**: Admin layout components

### Shared Resources

-   **`config/db.php`**: Database connection and helper functions
-   **`assets/css/style.css`**: Main stylesheet
-   **`assets/js/main.js`**: JavaScript with mobile menu functionality

## 📝 Key Learning Outcomes

This project demonstrates:

-   **PHP Fundamentals**: Object-oriented database connections, prepared statements, session management
-   **Database Design**: Relational database schema, foreign keys, normalization
-   **Authentication**: User registration, login, role-based access control
-   **Frontend Integration**: Responsive design, mobile-friendly menu, event handling
-   **CRUD Operations**: Create, read, update, delete functionality for posts
-   **Web Standards**: HTML5 semantics, CSS3 styling, JavaScript DOM manipulation

## 📱 Responsive Features

-   Mobile-friendly navigation with hamburger menu
-   Robust menu toggle functionality with multiple event listeners
-   Auto-close menu on navigation, resize, or Escape key
-   Overlay support for mobile menu
-   Accessibility attributes (aria-labels, aria-expanded)
-   Touch and pointer event support

-   **`index.php`**: The main landing page. It fetches and displays a paginated list of the latest published posts and highlights the single most-viewed post as "Featured".
-   **`post.php`**: Displays the full content of a single blog post, identified by its unique slug. It also handles the display and submission of comments for that post.
-   **`dashboard.php`**: A protected route for logged-in users. It serves as a control panel where users can view, create, edit, and delete their own posts.
-   **`config/db.php`**: Establishes the connection to the MySQL database using credentials and makes the connection object available to other scripts.
-   **`functions.php`**: A utility file containing common functions used across the site, such as checking user login status (`is_logged_in()`) and generating post excerpts (`display_excerpt()`). This file is typically included in `header.php`.
