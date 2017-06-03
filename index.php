<?php

/*
| Autoload
 */
require_once('autoload/autoload.php');

/*
| Pengaturan database
| Koneksi database dengan PDO
 */
$config = [
    'driver' => 'mysql:host=localhost;dbname=qasico',
    'user' => 'root',
    'password' => '',
    'option' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]
];

/*
| Instance Object untuk CRUD menggunakan Crud Library
 */
$crud = new \App\Libraries\Crud($config);
$crud->setTable('users');

/*
| Contoh Penggunaan create()
 */
$data = [
    'nama' => 'joko 4',
    'email' => 'sample@gmail.com',
    'phone' => '000999888999',
    'alamat' => 'alamat'
];
$crud->create($data);


/*
| Contoh Penggunaan read()
 */
$crud->where('id');
$user = $crud->read(1);

echo $user->nama . '<br />' . $user->email . '<br />' . $user->phone . '<br />' . $user->alamat . '<br />';

/*
| Contoh Penggunaan update()
 */
$set = [
    'nama' => 'joko sudarsono',
    'email' => 'update@example.com',
    'phone' => '000999888888',
    'alamat' => 'Update Alamat'
];
$crud->where('id');
$crud->update(2, $set);


/*
| Contoh Penggunaan delete()
 */
$crud->where('id');
$crud->delete(3);
