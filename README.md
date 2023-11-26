# tic4301
tic4301 project

This folder contains the relevant files to run the program to simulate a vulnerable Wedding Website for users to leave comments.

To Start:

1. Run Vagrant
2. Provision to Host - welcome.php, index.php, admin.php, config.php
3. Also include the .sql files to the host machine.
4. Provision to Attacker - SQL.txt, User.txt, Password.txt.
5. Import SQL localhost.sql and tic4301.sql into PHPmyAdmin.
6. To run the webpage, make sure that config.php is configured properly.
7. Start index.php on the host machine.
8. Use the Attacker machine to log on to the same webpage.

SQL Injection - Login Page (index.php)
1. Using the tool of your choice, you can insert SQL.txt to test the source codes.
2. The next test is to bypass login.
3. User.txt is for the user_id field, and Password.txt is for the password field

XSS - Form Page (welcome.php)
1. For XSS, you can use the scripts below to insert into the Form Page.


1. Stored XSS

<script>alert(document.domain)</script>

2. Reflected XSS

<script>alert(0)</script>

3. CSRF
<script>window.location.href = "http://www.google.com";</script>
