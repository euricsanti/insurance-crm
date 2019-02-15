Copyright © To Athul Sharma and Euric Santi

##All Rights Reserved ©
Coding development belongs to Atul; translation, concept and main idea Euric Santi.  We thank all people
involved in this project. This code can be used to public or private projects, under MIT License,
and can be used AS IS, we don't have any responsibility of it, thus will help you implement it and with logic.
Also appreciate to check it out and modifications you may seem appropriate.

The Project belongs to Celeste Multimedia ©, for more information contact at www.celestemultimedia.com.do

# Design

The project has a user friendly interface with different role types for every user, each role gives type of directives that
help management to have more control over all of it. The designed types are:

Super User: all access
Owner: Access to see but not modify
Sells: Edit and apply changes to policies and it's dependents
Cashier: Access to Point of Sales and register payments.

## Policies and dependants.

Every insurance company in the world uses a system of policies and its dependents. Our CRM allows management
to have these two items separated but together, just as they are in the daily basis; also provides each one with time-lines for
payments understood on the CRM as "end_dates", which sets notifications on each end date for it to be paid.

## POS (Point Of Sales)
This one is  designed to be opened and closed by the cashier, every Open/close function creates a unique ID that helps
management tracking movements of daily income/outcome. If an user opens the POS, no other can use it while it has it.

## INSTALATION
As it is a Laravel Framework development with PHP, AngularJS and JQuery, you are gonna need to set up a Linux Server with Apache to run it, also configure the Composer on it.

1) Php >= 5.6.4
2) Composer installed on the root directory of the project.
3) Git installed and accessible on project root folder.
4) Please clone the repo
5) Please run 'composer update'.
6) Sql database created for the project,
7) Please create .env file from .env.example file and add the database settings.
8) Please run 'php artisan key:generate' in terminal to generate unique key in .env file for project.
9) Please give 'storage' directory write permissions.

If need help configuring, contact us.

# Donations,
ETH: 0x6a6e6c2fc98851d28ec448701e20132122e9d2e5
BCH: 1EjDXgpcopDdyyF89dq3ejM8dBbGw5rjTY
BTC: 3HGYVyEV2EdvpnyBt68rSKf3jUP4mGcFxi
XMR: 47ugZPTSDhaexN3SrvH9KKYywewfVtEYhf5teQCt1cf6Ly5T5oMtkHPSgnF4gp39iRaSgJGf9fPhHTbMLvyab8FK8DSvTcC
www.paypal.me/CelesteMultimediaDO
