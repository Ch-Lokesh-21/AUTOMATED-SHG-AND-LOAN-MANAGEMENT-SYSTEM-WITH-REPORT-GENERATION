
# Automated SHG and Loan Management System with Report Generation

## Overview

This project is a **comprehensive management system** designed to streamline the administration and management of **Self Help Groups (SHGs)**, their members, and loan details. The system automates data entry, CRUD operations, and report generation processes, ensuring efficiency and accuracy for large-scale administrative tasks.

It was developed as part of an internship project at the **Andhra Pradesh State Co-Operative Bank Ltd. (APCOB)**, aimed at reducing the manual efforts involved in handling SHG details and loan-related data.

## Features

- **User Authentication:**
  - Secure login system ensuring only authorized users can access the system.
  - Two user roles: 
    - **Admin**: Full access to all features and data of all branches.
    - **User**: Restricted access to CRUD operations and reports specific to their assigned branch.

- **Excel Upload for Bulk Data Entry:**
  - Upload SHG, member, and loan details via Excel spreadsheets.
  - Automated validation and insertion of data from Excel files to the database.

- **CRUD Operations:**
  - **SHG Details**: Create, Read, Update, and Delete operations for SHG details.
  - **Member Details**: Manage individual members linked to specific SHGs.
  - **Loan Details**: Track and update loan records tied to SHG members.

- **Automated Report Generation:**
  - Generate detailed reports that combine SHG, member, and loan data, making it easier to track and analyze group-level loan statuses.
  - Export reports in **Excel** and **PDF** formats.

- **Admin Dashboard:**
  - A comprehensive dashboard for admins to oversee SHG activities across multiple branches.
  - Upload/download data and view real-time statistics of loan repayments, outstanding balances, etc.

## Technologies Used

- **Frontend:**
  - HTML, CSS, JavaScript, Bootstrap for a responsive and user-friendly interface.

- **Backend:**
  - PHP for server-side logic and handling user requests.
  - **phpSpreadsheet** for handling Excel uploads and downloads.
  - **MySQL** for database management and CRUD operations.

- **Other Tools and Libraries:**
  - **PHPExcel** for working with Excel files.
  - **TCPDF** for generating PDF reports.

## Installation and Setup

### Prerequisites
- PHP 7.4+
- MySQL 5.7+
- Apache Server (XAMPP or any other web server)

### Installation Steps
1. Clone the repository:
    ```bash
    git clone https://github.com/Ch-Lokesh-21/AUTOMATED-SHG-AND-LOAN-MANAGEMENT-SYSTEM-WITH-REPORT-GENERATION.git
    ```

2. Navigate to the project directory:
    ```bash
    cd AUTOMATED-SHG-AND-LOAN-MANAGEMENT-SYSTEM-WITH-REPORT-GENERATION
    ```

3. Set up the database:
    - Import the provided SQL file located in the `database` folder into your MySQL server.
    - Ensure that the database credentials (username, password) in the `config.php` file match your MySQL setup.

4. Configure environment:
    - Adjust PHP and MySQL settings as needed in your `php.ini` and `my.cnf` files.

5. Start the server:
    - Run XAMPP (or other server software) and access the project via `http://localhost`.

### Running the Application
- Login as an admin or user, and start managing SHGs, their members, and loan data.
- Use the Excel upload feature for bulk data entry and generate reports instantly.

## Contribution
Feel free to contribute to this project by opening issues and submitting pull requests.
