<?php
class General_library
{
    protected $nikita;
    public $userLoggedIn;
    public $params;
    public $bios_serial_num;

    public function __construct()
    {
        $this->nikita = &get_instance();
        $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in')[0];
        $this->params = $this->nikita->session->userdata('params');
        $this->bios_serial_num = shell_exec('wmic bios get serialnumber 2>&1');
        date_default_timezone_set("Asia/Singapore");
    }

    public function getBiosSerialNum(){
        $info = $this->bios_serial_num;
        return trim($info);
    }

    public function refreshUserLoggedInData(){
        $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in')[0];
    }

    public function refreshParams(){
        $this->params = $this->nikita->session->userdata('params');
        if($this->params){
            foreach($this->params as $p){
                $this->nikita->session->set_userdata([$p['parameter_name'] => null]);
                $this->nikita->session->set_userdata([$p['parameter_name'] => $p]);
            }
        }
    }

    public function getProfilePicture(){
        $photo = 'assets/img/user2-160x160.jpg';
        if($this->userLoggedIn['profile_picture']){
            $photo = 'assets/profile_picture/'.$this->userLoggedIn['profile_picture'];
        }
        return base_url().$photo;
    }

    public function getParams($parameter_name = ''){
        return $this->nikita->session->userdata($parameter_name);
        // $this->params = $this->nikita->session->userdata('params');
        // if($parameter_name != ''){
        //     foreach($this->params as $p){
        //         if($p['parameter_name'] == $parameter_name){
        //             return $p;
        //         }
        //     }
        // } else {
        //     return $this->params;
        // }
    }

    public function getDataProfilePicture(){
        return $this->userLoggedIn['profile_picture'];
    }

    public function getPassword(){
        return $this->userLoggedIn['password'];
    }

    public function isNotAppExp(){
        $exp_app = $this->getParams('PARAM_EXP_APP');
        if(date('Y-m-d H:i:s') <= $exp_app['parameter_value']){
            return true;
        } else {
            return false;
        }
    }

    public function isNotBackDateLogin(){
        $login_param = $this->getParams('PARAM_LAST_LOGIN');
        if(date('Y-m-d H:i:s') >= $login_param['parameter_value']){
            return true;
        } else {
            return false;
        }
    }

    public function isNotThisDevice(){
        $exp_app = $this->getParams('PARAM_BIOS_SERIAL_NUMBER');
        if(DEVELOPMENT_MODE == 0){
            echo ($exp_app['parameter_value']);
            dd($this->getBiosSerialNum());
            if($this->getBiosSerialNum() != $exp_app['parameter_value']){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function isSessionExpired(){
        if(!$this->userLoggedIn){
            $this->nikita->session->set_userdata(['apps_error' => 'Sesi Anda telah habis. Silahkan Login kembali']);
            return null;
        }
        return $this->userLoggedIn;
    }

    public function isLoggedIn($exclude_role = []){
        if(!$this->userLoggedIn){
            $this->nikita->session->set_userdata(['apps_error' => 'Sesi Anda telah habis. Silahkan Login kembali']);
            return null;
        }
        if(!$this->isNotBackDateLogin()){
            $this->nikita->session->set_userdata(['apps_error' => 'Back Date detected. Make sure Your Date and Time is not less than today. If this message occur again, call '.PROGRAMMER_PHONE.'']);
            return null;
        }
        if(!$this->isNotAppExp()){
            $this->nikita->session->set_userdata(['apps_error' => 'Masa Berlaku Aplikasi Anda sudah habis']);
            return null;
        }
        if($this->isNotThisDevice()){
            $this->nikita->session->set_userdata(['apps_error' => 'Device tidak terdaftar']);
            return null;
        }
        if(count($exclude_role > 1) && in_array($this->getRole(), $exclude_role)){
            $this->nikita->session->set_userdata(['apps_error' => 'Role User tidak diizinkan untuk masuk ke menu tersebut']);
            return null;
        }
        return $this->userLoggedIn;
    }

    public function getUserName(){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        return $this->userLoggedIn['username'];
    }

    public function getNamaUser(){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        return $this->userLoggedIn['nama_user'];
    }

    public function getRole(){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        return $this->userLoggedIn['role_name'];
    }

    public function getId(){
        // $this->userLoggedIn = $this->nikita->session->userdata('user_logged_in');
        return $this->userLoggedIn['id'];
    }

    public function test(){
        return 'tiokors';
    }

    public function encrypt($username, $password)
    {
        $key = 'nikita_sakobar';
        $userKey = substr($username, -3);
        $passKey = substr($password, -3);
        $generatedForHash = strtoupper($userKey).$username.$key.strtoupper($passKey).$password;
        return md5($generatedForHash);
    }

    public function uploadImage($path, $input_file_name){
        if (!file_exists(URI_UPLOAD.$path)) {
            mkdir(URI_UPLOAD.$path, 0777, true);
        }
        $file = $_FILES["$input_file_name"];
        $fileName = $this->getUserName().'_profile_pict_'.date('ymdhis').'_'.$file['name'];
        
        $_FILES[$input_file_name]['name'] = $file['name'];
        $_FILES[$input_file_name]['type'] = $file['type'];
        $_FILES[$input_file_name]['tmp_name'] = $file['tmp_name'];
        $_FILES[$input_file_name]['error'] = $file['error'];
        $_FILES[$input_file_name]['size'] = $file['size'];
        
        $config['upload_path'] = URI_UPLOAD.$path; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = '2000';

        $this->nikita->load->library('upload', $config);

        if(!$this->nikita->upload->do_upload($input_file_name)){
            $this->nikita->upload->display_errors();
        }
        if($this->nikita->upload->error_msg){
            return ['code' => '500', 'message' => $this->nikita->upload->error_msg[0]];
        }
        $image = $this->nikita->upload->data();
        // $width_size = 160;
        // $filesave = base_url('assets/profile_picture/').$image['file_name'];

        // // menentukan nama image setelah dibuat
        // $resize_image = 'resize_'.$image['file_name'];

        // // mendapatkan ukuran width dan height dari image
        // list( $width, $height ) = getimagesize($filesave);

        
        // // mendapatkan nilai pembagi supaya ukuran skala image yang dihasilkan sesuai dengan aslinya
        // $k = $width / $width_size;

        // // menentukan width yang baru
        // $newwidth = $width / $k;

        // // menentukan height yang baru
        // $newheight = $height / $k;

        // // fungsi untuk membuat image yang baru
        // $thumb = imagecreatetruecolor($newwidth, $newheight);
        // $source = imagecreatefromjpeg($filesave);

        // // men-resize image yang baru
        // imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        // // menyimpan image yang baru
        // imagejpeg($thumb, $resize_image);

        // imagedestroy($thumb);
        // imagedestroy($source);
        // $image['file_name'] = $resize_image;
        return ['code' => '0', 'data' => $image];
    }
}
?>