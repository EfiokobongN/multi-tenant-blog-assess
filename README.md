LARAVEL PHP BACKEND DEVELOPER ASSESSMENT

Creating Admin User using tinker
--command: php artisan tinker
--User::create(['name'=> 'Admin', 'email'=> 'admin@gmail.com', 'password'=> Hash::make('Pasword1234'), 'role'=>'admin', 'is_approved'=> true, 'tenant-id' => null])