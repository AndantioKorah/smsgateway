<?php
	class M_Backup extends CI_Model
	{
        public $bios_serial_num;

        public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
            $this->forge = $this->load->dbforge($this->db, TRUE);
            $this->bios_serial_num = shell_exec('wmic bios get serialnumber 2>&1');
        }

        public function backupDatabase(){
            $tables = null;
            $new_db_name = 'db_lab_bu_'.date('ymdhis');
            if($this->forge->create_database($new_db_name)){
                $db_bu_connection = [
                    'dsn'	=> '',
                    'hostname' => DB_HOST,
                    'username' => DB_USERNAME,
                    'password' => DB_PASSWORD,
                    'database' => $new_db_name,
                    'dbdriver' => 'mysqli',
                    'dbprefix' => '',
                    'pconnect' => FALSE,
                    'db_debug' => (ENVIRONMENT !== 'production'),
                    'cache_on' => FALSE,
                    'cachedir' => '',
                    'char_set' => 'utf8',
                    'dbcollat' => 'utf8_general_ci',
                    'swap_pre' => '',
                    'encrypt' => FALSE,
                    'compress' => FALSE,
                    'stricton' => FALSE,
                    'failover' => array(),
                    'save_queries' => TRUE
                ];
                $db_bu = $this->load->database($db_bu_connection, true);
                $success = 1;
                $tables = $this->db->list_tables();
                if($tables){
                    foreach($tables as $t){
                        $query = $this->db->query('SHOW CREATE TABLE '.$t);
                        // echo 'creating '.$t.PHP_EOL;
                        if($db_bu->query($query->result_array()[0]['Create Table'])){
                            // echo 'created table '.$t.PHP_EOL;
                            // echo 'select insert into new database '.PHP_EOL;
                            if($db_bu->query('INSERT INTO '.$t.' SELECT * FROM db_lab.'.$t)){
                                // echo $t. 'done'.PHP_EOL;
                            } else {
                                $success = 0;
                            }
                        } else {
                            $success = 0;
                        }
                    }
                    if($success == 0){
                        echo 'Error occured. trying to delete '.$new_db_name."\r\n";
                        if ($this->dbforge->drop_database($new_db_name)){
                            echo 'delete success';
                        } else {
                            echo 'something went wrong';
                        }
                    } else {
                        echo 'backup db done: '.$new_db_name;
                    }
                }
            }
        }
	}
?>