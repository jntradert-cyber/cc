SUPERMARKET INFORMATION SYSTEM - UPDATED

INSTALLATION
1. Extract folder into C:\xampp\htdocs\
2. Start Apache and MySQL in XAMPP.
3. Import database.sql in phpMyAdmin.
4. Check config.php database username/password (XAMPP default root / blank).
5. Visit http://localhost/supermarket_information_system/setup.php
6. Visit http://localhost/supermarket_information_system/
7. Delete setup.php after creating demo accounts.

DEMO LOGINS
Employee: employee / employee123
Customer: customer / customer123

REGISTRATION
Customers register from Home and receive a customer profile.
Employees register from Home using code STAFF-2026 for local testing.
Change EMPLOYEE_REGISTRATION_CODE in config.php before deployment.

DATABASE TABLES
users: shared login information and role.
customers: customer phone and address linked to users.
employees: employee number, department and phone linked to users.
products, purchases and purchase_items: product, order and invoice data.

FEATURES
Home page; benefits for customer and employee registration; account registration;
role-based login; password change; employee inventory; customer shopping;
pagination; purchase processing; invoice and purchase history.

SECURITY
Passwords use password_hash() and password_verify(). PDO prepared statements
are used. Employee registration code is only a basic classroom gate, not full
staff approval. For public deployment add HTTPS, CSRF protection, rate limiting,
secure configuration, backups and administrator approval. Change demo passwords
and employee code. Delete setup.php.
