<?php
$route['users'] = 'user/C_User/users';
$route['user/setting'] = 'user/C_User/userSetting';
$route['roles'] = 'user/C_User/roles';
$route['menu'] = 'user/C_User/menu';
$route['pelayanan'] = 'pelayanan/C_Pelayanan/inputTindakan';
$route['pendaftaran'] = 'pendaftaran/C_Pendaftaran/pendaftaran';
$route['pasien/(:any)'] = 'pendaftaran/C_Pendaftaran/dataPasien/$1';
