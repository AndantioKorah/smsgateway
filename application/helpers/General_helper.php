<?php

function dd($var)
{
    die(var_dump($var));
}

function render($pageContent, $parent_active, $active, $data)
{
    $CI = &get_instance();
    $data['page_content'] = $pageContent;
    $data['parent_active'] = $parent_active;
    $data['active'] = $active;
    $CI->load->view('base/V_BaseLayout', $data);
}

function explodeRangeDate($date){
    $tanggal = explode("-", $date);
    $awal = explode("/", $tanggal[0]);    
    $akhir = explode("/", $tanggal[1]);
    
    $start_date = trim($awal[2]).'-'.trim($awal[1]).'-'.trim($awal[0]);
    $end_date = trim($akhir[2]).'-'.trim($akhir[1]).'-'.trim($akhir[0]);
    return [$start_date, $end_date];
}

function getStatusTransaksi($status){
    switch($status){
        case 1:
            return 'Aktif'; break;
        case 2:
            return 'Lunas'; break;
        case 3:
            return 'Belum Lunas'; break;
        default:
            return '';
    }
}

function clearString($str){
    return str_replace('.', '', preg_replace('/[^0-9.\.]+/', '', (trim($str))));
}

function formatCurrency($data)
{
    return "Rp " . number_format($data, 0, ",", ".");
}

function formatCurrencyWithoutRp($data)
{
    return number_format($data, 0, ",", ".");
}

function formatDateOnly($data)
{
    $date1 = strtr($data, '/', '-');
    return date("d/m/Y", strtotime($date1));
}

function formatDate($data)
{
    $date1 = strtr($data, '/', '-');
    return date("d/m/Y H:i:s", strtotime($date1));
}

function formatDateOnlyForEdit($data)
{
    return date("Y-m-d", strtotime($data));
}

function formatDateForEdit($data)
{
    return date("Y-m-d H:i:s", strtotime($data));
}

function countDiffDateLengkap($date1, $date2, $params = ''){
    $total_waktu = "";
    $tahun = 0;
    $bulan = 0;
    $hari = 0;
    $jam = 0;
    $menit = 0;
    $detik = 0;

    $date1 = strtotime($date1);
    $date2 = strtotime($date2);
    $diff = abs($date2 - $date1);

    $tahun = floor($diff / (365*60*60*24));
    $bulan = floor(($diff - $tahun * 365*60*60*24)/(30*60*60*24));
    $hari = floor(($diff - $tahun * 365*60*60*24 -  $bulan*30*60*60*24)/ (60*60*24)); 
    $jam = $hours = floor(($diff - $tahun * 365*60*60*24 - $bulan*30*60*60*24 - $hari*60*60*24) / (60*60));
    $menit = floor(($diff - $tahun * 365*60*60*24 - $bulan*30*60*60*24 - $hari*60*60*24 - $jam*60*60)/ 60);
    $detik = floor(($diff - $tahun * 365*60*60*24 - $bulan*30*60*60*24 - $hari*60*60*24 - $jam*60*60 - $menit*60)); 
    
    if($tahun != '0' && in_array('tahun', $params)){
        $total_waktu = $total_waktu.' '.$tahun.' tahun';
    } 
    if($bulan != '0' && in_array('bulan', $params)){
        $total_waktu = $total_waktu.' '.$bulan.' bulan';
    } 
    if($hari != '0' && in_array('hari', $params)){
        $total_waktu = $total_waktu.' '.$hari.' hari';
    } 
    if($jam != '0' && in_array('jam', $params)){
        $total_waktu = $total_waktu.' '.$jam.' jam';
    } 
    if($menit != '0' && in_array('menit', $params)){
        $total_waktu = $total_waktu.' '.$menit.' menit';
    } 
    if($detik != '0' && in_array('detik', $params)){
        $total_waktu = $total_waktu.' '.$detik.' detik';
    }
    if(strlen($total_waktu) == 0){
        $total_waktu = 'Hari Ini';
    }
    return $total_waktu;
}

function terbilang($x){
    $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");

    if ($x < 12)
    return " " . $abil[$x];

    elseif ($x < 20)
    return terbilang($x - 10) . " Belas";
    elseif ($x < 100)
    return terbilang($x / 10) . " Puluh" . terbilang($x % 10);
    elseif ($x < 200)
    return " Seratus" . terbilang($x - 100);
    elseif ($x < 1000)
    return terbilang($x / 100) . " Ratus" . terbilang($x % 100);
    elseif ($x < 2000)
    return " Seribu" . terbilang($x - 1000);
    elseif ($x < 1000000)
    return terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
    elseif ($x < 1000000000)
    return terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
    else
    return terbilang($x / 1000000000). " Miliar ". terbilang($x % 1000000000);
}


function encrypt($string1, $string2){
    $key = 'nikitapos'.DEVELOPER;
    $userKey = substr($string1, -3);
    $passKey = substr($string2, -3);
    $generatedForHash = strtoupper($userKey).$string1.$key.strtoupper($passKey).$string2;
    return md5($generatedForHash);
    // return $this->general_library->encrypt($string1, $string2);
}

function encrypt_custom($pure_string) {
    $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
    
    $key_size =  strlen($key);
    
    $plaintext = $pure_string;

    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    
    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
                                 $plaintext, MCRYPT_MODE_CBC, $iv);

    $ciphertext = $iv . $ciphertext;
    
    $ciphertext_base64 = base64_encode($ciphertext);
    
    return $ciphertext_base64;
}

function decrypt_custom($encrypted_string) {
    $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

    $ciphertext_dec = base64_decode($encrypted_string);
    
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    
    # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
    $iv_dec = substr($ciphertext_dec, 0, $iv_size);
    
    # retrieves the cipher text (everything except the $iv_size in the front)
    $ciphertext_dec = substr($ciphertext_dec, $iv_size);

    # may remove 00h valued characters from end of plain text
    $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
                                    $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);

    return $plaintext_dec;
}