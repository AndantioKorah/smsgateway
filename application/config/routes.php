<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = 'login/C_Login/notFoundOverride';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'login/C_Login/login';
$route['logout'] = 'login/C_Login/logout';

// admin
$route['welcome'] = 'login/C_Login/welcomePage';
$route['admin'] = 'admin/C_Admin/index';
$route['admin/dashboard'] = 'admin/C_Admin/dashboard';
$route['admin/barang'] = 'admin/C_Admin/barang';
$route['admin/barang/kategori'] = 'admin/C_Admin/kategori_barang';
$route['admin/barang/sub-kategori'] = 'admin/C_Admin/sub_kategori_barang';
$route['admin/barang/item'] = 'admin/C_Admin/item_barang';
$route['admin/barang/stock'] = 'admin/C_Admin/stock_barang';

//master transaksi
$route['master/transaksi/pengeluaran'] = 'admin/C_Admin/masterPengeluaran';
$route['master/transaksi/pembelian'] = 'admin/C_Admin/masterPembelian';

$route['transaksi/pengeluaran'] = 'admin/C_Admin/transaksiPengeluaran';
$route['transaksi/pengeluaran/detail/(:any)'] = 'admin/C_Admin/detailPengeluaran/$1';
$route['transaksi/pembelian'] = 'admin/C_Admin/transaksiPembelian';
$route['transaksi/pembelian/detail/(:any)'] = 'admin/C_Admin/detailPembelian/$1';

// pos
$route['kasir'] = 'pos/C_Pos/pos';

$route['roles'] = 'user/C_User/roles';
$route['users'] = 'user/C_User/users';
$route['user/setting'] = 'user/C_User/userSetting';

$route['developer'] = 'user/C_User/developer';

$route['laporan/transaksi'] = 'laporan/C_Laporan/laporanTransaksi';
$route['laporan/penjualan'] = 'laporan/C_Laporan/laporanPenjualan';
$route['laporan/pembayaran'] = 'laporan/C_Laporan/laporanPembayaran';
$route['laporan/rekap/harian'] = 'laporan/C_Laporan/rekapHarian';

$route['apps/setting'] = 'parameter/C_Parameter/settingApps';
$route['bios'] = 'parameter/C_Parameter/biosSerialNumber';