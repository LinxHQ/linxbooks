# Linxbooks
Open-source accounting software (customers, invoices, quotations, bills, expenses, payrolls and reports). LinxBooks is a product of LinxHQ Pte Ltd, actively developed and maintained by a Vietnamese Team at LinxHQ.

Product Website: http://www.linxbooks.com

Contact:
Joseph Pham, joseph.pnc@linxhq.com

## Features
* Create and manage multiple users and their permissions
* Manage customers and vendors
* Create, delete, edit quotations, invoices and bills
* Record payments
* Keep track of company expenses…
* Generate Reports
* Export to PDF.
* Send email reminder

## How to install
* Download the code and put it in your web server (a folder of your choice in your web folder)
* Create a Mysql databaes for your installation
* Import the following sql into the database: sql/linxbooks20170503.sql. 
* DB info can be edited at protected/config/db.php. 
* Email server settings (for notification) can also be edited at protected/config/main.php
* Username is admin, pass is admin123

## Demo
* http://linxbooks.com/demo (user: admin, password: admin123)

## Technical details

We use the following:
* PHP
* MySQL as database server
* Apache Web server is recommended
* Yii framework 1.1.14
* Bootstrap
* JQuery
* 

## Change Log

For weekly/regular updates, please refer to CHANGELOG


'' Copyright (c) 2015. LinxHQ Pte Ltd ''
