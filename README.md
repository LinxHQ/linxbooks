# LinxOne (formerly LinxBooks)
Open-source accounting software (customers, invoices, quotations, bills, expenses, payrolls and reports). LinxOne is a product of LinxHQ Pte Ltd, actively developed and maintained by a Vietnamese Team at LinxHQ.

![Dashboard](/invoicedashboard.png?raw=true "Dashboard")


Contact:
Joseph Pham, joseph.pnc@linxhq.com

Checkout out demo at: http://sit.linxhq.com/linxone using username: admin, password: admin123

I have to be honest the demo version might work more smoothly than the version we have here on github. For that we apologize, we'll try to get the setup process more solid as soon as possible.

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
* Create a Mysql database for your installation
* Import the following sql into the database: sql/setup.sql. 
* DB info can be edited at protected/config/db.php. 
* Email server settings (for notification) can also be edited at protected/config/main.php
* Username is admin, pass is admin123
* Grant write permission to assets, profile photos, and protected/runtime folders.

## Technical details

We use the following:
* PHP
* MySQL database server
* Apache Web server
* Yii MVC framework
* Bootstrap
* JQuery
* and you know, the basic html/css stuff...

'' Copyright (c) 2013-2018. LinxHQ Pte Ltd ''
