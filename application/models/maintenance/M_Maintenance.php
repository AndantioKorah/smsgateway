<?php
	class M_Maintenance extends CI_Model
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
                        $this->generateScriptQuery($new_db_name);
                    }
                }
            }
        }

        public function generateScriptQuery($new_db_name){
            // Database configuration
            $host = DB_HOST;
            $username = DB_USERNAME;
            $password = DB_PASSWORD;
            $database_name = DB_NAME;

            // Get connection object and set the charset
            $conn = mysqli_connect($host, $username, $password, $database_name);
            $conn->set_charset("utf8");

            // Get All Table Names From the Database
            $tables = array();
            $sql = "SHOW TABLES";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_row($result)) {
                $tables[] = $row[0];
            }

            $sqlScript = "";
            foreach ($tables as $table) {
                
                // Prepare SQLscript for creating table structure
                $query = "SHOW CREATE TABLE $table";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_row($result);
                
                $sqlScript .= "\n\n" . $row[1] . ";\n\n";
                
                
                $query = "SELECT * FROM $table";
                $result = mysqli_query($conn, $query);
                
                $columnCount = mysqli_num_fields($result);
                
                // Prepare SQLscript for dumping data for each table
                for ($i = 0; $i < $columnCount; $i ++) {
                    while ($row = mysqli_fetch_row($result)) {
                        $sqlScript .= "INSERT INTO $table VALUES(";
                        for ($j = 0; $j < $columnCount; $j ++) {
                            $row[$j] = $row[$j];
                            
                            if (isset($row[$j])) {
                                $sqlScript .= '"' . $row[$j] . '"';
                            } else {
                                $sqlScript .= '""';
                            }
                            if ($j < ($columnCount - 1)) {
                                $sqlScript .= ',';
                            }
                        }
                        $sqlScript .= ");\n";
                    }
                }
                $sqlScript .= "\n"; 
            }

            if(!empty($sqlScript)){
                // Save the SQL script to a backup file
                if (!file_exists(DB_BACKUP_FOLDER)){
                    mkdir(DB_BACKUP_FOLDER, 0777, true);
                }
                $backup_file_txt_name = DB_BACKUP_FOLDER.$new_db_name.'.txt';
                $fileHandler = fopen($backup_file_txt_name, 'w+');
                $number_of_lines = fwrite($fileHandler, $sqlScript);
                fclose($fileHandler);

                $backup_file_name = DB_BACKUP_FOLDER.$new_db_name.'.sql';
                $fileHandler = fopen($backup_file_name, 'w+');
                $number_of_lines = fwrite($fileHandler, $sqlScript);
                fclose($fileHandler);

                $maintenance['created_by'] = $this->general_library->getId();
                $maintenance['db_name'] = $new_db_name;
                $maintenance['sql_file'] = $backup_file_name;
                $maintenance['txt_file'] = $backup_file_txt_name;
                $maintenance['jenis_maintenance'] = 'backup';
                $this->db->insert('t_maintenance', $maintenance);

                // Download the SQL backup file to the browser
                // header('Content-Description: File Transfer');
                // header('Content-Type: application/octet-stream');
                // header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
                // header('Content-Transfer-Encoding: binary');
                // header('Expires: 0');
                // header('Cache-Control: must-revalidate');
                // header('Pragma: public');
                // header('Content-Length: ' . filesize($backup_file_name));
                // ob_clean();
                // flush();
                // readfile($backup_file_name);
                // exec('rm ' . $backup_file_name); 
            }
        }

        public function getHistoryBackup(){
            return $this->db->select('a.*, b.nama')
                            ->from('t_maintenance a')
                            ->join('m_user b', 'a.created_by = b.id')
                            ->where('a.flag_active', 1)
                            ->order_by('a.created_date', 'desc')
                            ->get()->result_array();
        }
	}
?>