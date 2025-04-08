LARAVEL PHP BACKEND DEVELOPER ASSESSMENT
Multi-Tenant Blog API Endpoint

#A multi-tenant blog API system built with laravel. This system demonstrates authentication role base access (Admin & tenant), Tenant Isolation and authorization using Laravel Sanctum.
---------

## Features
-Tenant user registration "pending Approval"
-Admin approval system to activated tenant accounts.
-Tenant level CRUD for blog post
-Admin has access to view all tenants Post
-RESTFUL API with sanctun token-base authentication
-Policy & middleware-base accesss control

---

##Requirements
-PHP>= 8.1
-composer
-MYSQL
-POSTMAN (for testing)

--------

## SETUP INSTRUCTION

```BASH or command prompt
#  1. Clone the repository
- git clone https://github.com/EfiokobongN/multi-tenant-blog-assess.git

- Cd multi-tenant-blog-assess

# 2. Install dependencies
- composer install

# 3. Create enviroment file
- cp .env.example  .env

# 4. Generate application key
. php artisan key:generate

# 5. configure your ienv (DB details)

# 6.Run Migration
. php artisanmigrate

# 7.Create Default admin
--command: php artisan tinker
--User::create(['name'=> 'Admin', 'email'=> 'admin@gmail.com', 'password'=> Hash::make('Pasword1234'), 'role'=>'admin', 'is_approved'=> true, 'tenant-id' => null])


#Application Structure
|-- app
│   |-- Http
|   |   |--Controller
|   |   |   |--AdminController.php
|   |   |   |--AuthController.php
|   |   |   |--PostController.php
|   |   |--Middleware
|   |   |   |--IsAccountApproved.php
|   |   |   |--IsAdmin.php
|   |--Models
|   |   |--Post.php
|   |   |--Tenant.php
|   |   |--User.php
|   |--Policies
|   |   |--TenantPostPolicy.php
|-- Database
│   |-- migrations
|   |   |---2014_10_12_000000_create_users_table.php
|   |   |---2025_04_06_121045_create_tenants_table.php
|   |   |---2025_04_06_130654_create_posts_table.php
|   |   |---2025_04_07_095657_add_tenant_id_to_users_table.php
|-- routes
│   |-- api.php
|-- README.md


## Roles

Role         Description

-- Admin      Approve pending Account and see all tenants posts
-- Tenant     Can CRUD post within their tenant


## Approval Flows
--- Tenant Register (api/register)
---Admin aproves user and tenant is create (api//admin/approve/user_id)
--- Tenant Receive access