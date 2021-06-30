<?php
	class M_Pos extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function createNewTransaksi($data){
            $this->db->trans_begin();

            $data['nomor_transaksi'] = KODE_TRANSAKSI.date('dmyhis');
            $data['status'] = "1";
            $this->insert('t_transaksi', $data);
            $last_id = $this->db->insert_id();

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                return ['last_id' => 0];
            } else {
                $this->db->trans_commit();
                return ['last_id' => $last_id];
            }
        }

        public function reloadListTransaksi($year, $month, $date){
            return $this->db->select('*')
                            ->from('t_transaksi')
                            // ->where('status', 1)
                            ->where('flag_active', 1)
                            ->where('YEAR(tanggal_transaksi)', $year)
                            ->where('MONTH(tanggal_transaksi)', $month)
                            ->where('DAY(tanggal_transaksi)', $date)
                            ->order_by('status')
                            ->order_by('created_date', 'desc')
                            ->get()->result_array();
        }

        public function loadTransaksiAktif($year, $month, $date){
            return $this->db->select('*')
                            ->from('t_transaksi')
                            ->where('status', 1)
                            ->where('flag_active', 1)
                            ->where('YEAR(tanggal_transaksi)', $year)
                            ->where('MONTH(tanggal_transaksi)', $month)
                            ->where('DAY(tanggal_transaksi)', $date)
                            ->order_by('tanggal_transaksi', 'desc')
                            ->get()->result_array();
        }

        public function searchTransaksi($params){
            $query = "SELECT *
                FROM t_transaksi a
                JOIN m_status_transaksi b ON a.status = b.id_m_status_transaksi
                WHERE a.flag_active = 1
                AND YEAR(tanggal_transaksi) = ".$params['tahun']."
                AND MONTH(tanggal_transaksi) = ".$params['bulan']."
                AND DAY(tanggal_transaksi) = ".$params['tanggal']."
                AND (nama LIKE '%".$params['search']."%' ESCAPE '!'
                OR nomor_transaksi LIKE '%".$params['search']."%' ESCAPE '!'
                OR tanggal_transaksi LIKE '%".$params['search']."%' ESCAPE '!'
                OR total_biaya LIKE '%".$params['search']."%' ESCAPE '!'
                OR nomor_meja LIKE '%".$params['search']."%' ESCAPE '!'
                OR jumlah_orang LIKE '%".$params['search']."%' ESCAPE '!'
                OR nama_status_transaksi LIKE '%".$params['search']."%' ESCAPE '!'
                OR jenis_transaksi LIKE '%".$params['search']."%' ESCAPE '!')
                ORDER BY a.created_date DESC";
            return $this->db->query($query)->result_array();
        }

        public function searchTransaksiAktif($params){
            $query = "SELECT *
                FROM t_transaksi
                WHERE flag_active = 1
                AND status = 1
                AND YEAR(tanggal_transaksi) = ".$params['tahun']."
                AND MONTH(tanggal_transaksi) = ".$params['bulan']."
                AND DAY(tanggal_transaksi) = ".$params['tanggal']."
                AND (nama LIKE '%".$params['search']."%' ESCAPE '!'
                OR nomor_transaksi LIKE '%".$params['search']."%' ESCAPE '!'
                OR tanggal_transaksi LIKE '%".$params['search']."%' ESCAPE '!'
                OR total_biaya LIKE '%".$params['search']."%' ESCAPE '!'
                OR nomor_meja LIKE '%".$params['search']."%' ESCAPE '!'
                OR jumlah_orang LIKE '%".$params['search']."%' ESCAPE '!')
                ORDER BY tanggal_transaksi DESC";
            return $this->db->query($query)->result_array();
        }

        public function loadTransaksiLunas($year, $month, $date){
            return $this->db->select('*')
                            ->from('t_transaksi')
                            ->where('status', 2)
                            ->where('flag_active', 1)
                            ->where('YEAR(tanggal_transaksi)', $year)
                            ->where('MONTH(tanggal_transaksi)', $month)
                            ->where('DAY(tanggal_transaksi)', $date)
                            ->order_by('tanggal_transaksi', 'desc')
                            ->get()->result_array();
        }

        public function searchTransaksiLunas($params){
            $query = "SELECT *
                FROM t_transaksi
                WHERE flag_active = 1
                AND status = 2
                AND YEAR(tanggal_transaksi) = ".$params['tahun']."
                AND MONTH(tanggal_transaksi) = ".$params['bulan']."
                AND DAY(tanggal_transaksi) = ".$params['tanggal']."
                AND (nama LIKE '%".$params['search']."%' ESCAPE '!'
                OR nomor_transaksi LIKE '%".$params['search']."%' ESCAPE '!'
                OR tanggal_transaksi LIKE '%".$params['search']."%' ESCAPE '!'
                OR total_biaya LIKE '%".$params['search']."%' ESCAPE '!'
                OR nomor_meja LIKE '%".$params['search']."%' ESCAPE '!'
                OR jumlah_orang LIKE '%".$params['search']."%' ESCAPE '!')
                ORDER BY tanggal_transaksi DESC";
            return $this->db->query($query)->result_array();
        }

        public function loadTransaksiBelumLunas($year, $month, $date){
            return $this->db->select('*')
                            ->from('t_transaksi')
                            ->where('status', 3)
                            ->where('flag_active', 1)
                            ->where('YEAR(tanggal_transaksi)', $year)
                            ->where('MONTH(tanggal_transaksi)', $month)
                            ->where('DAY(tanggal_transaksi)', $date)
                            ->order_by('tanggal_transaksi', 'desc')
                            ->get()->result_array();
        }

        public function searchTransaksiBelumLunas($params){
            $query = "SELECT *
                FROM t_transaksi
                WHERE flag_active = 1
                AND status = 3
                AND YEAR(tanggal_transaksi) = ".$params['tahun']."
                AND MONTH(tanggal_transaksi) = ".$params['bulan']."
                AND DAY(tanggal_transaksi) = ".$params['tanggal']."
                AND (nama LIKE '%".$params['search']."%' ESCAPE '!'
                OR nomor_transaksi LIKE '%".$params['search']."%' ESCAPE '!'
                OR tanggal_transaksi LIKE '%".$params['search']."%' ESCAPE '!'
                OR total_biaya LIKE '%".$params['search']."%' ESCAPE '!'
                OR nomor_meja LIKE '%".$params['search']."%' ESCAPE '!'
                OR jumlah_orang LIKE '%".$params['search']."%' ESCAPE '!')
                ORDER BY tanggal_transaksi DESC";
            return $this->db->query($query)->result_array();
        }

        public function loadSelectedTransaksi($id){
            $transaksi = $this->db->select('*')
                                ->from('t_transaksi')
                                ->where('flag_active', 1)
                                ->where('id', $id)
                                ->get()->row_array();

            $detail_transaksi = $this->db->select('a.*, b.nama_item')
                                        ->from('t_transaksi_detail a')
                                        ->join('m_item_barang b', 'a.id_m_item_barang = b.id')
                                        ->where('a.flag_active', 1)
                                        ->where('a.id_t_transaksi', $id)
                                        ->order_by('a.created_date', 'desc')
                                        ->get()->result_array();
            return [$transaksi, $detail_transaksi];
        }

        public function editTransaksi($data_edit, $id){
            $this->db->where('id', $id)
                    ->update('t_transaksi', $data_edit);
        }

        public function tambahDetailTransaksi($data_input){
            $transaksi = $this->db->select('*')
                                ->from('t_transaksi')
                                ->where('id', $data_input['id_t_transaksi'])
                                ->where('flag_active', 1)
                                ->get()->row_array();
            
            $exist = $this->db->select('*')
                            ->from('t_transaksi_detail')
                            ->where('harga_per_item', $data_input['harga_per_item'])
                            ->where('id_m_item_barang', $data_input['id_m_item_barang'])
                            ->where('id_t_transaksi', $data_input['id_t_transaksi'])
                            ->where('catatan', $data_input['catatan'])
                            ->where('flag_active', 1)
                            ->get()->row_array();

            $this->db->trans_begin();
            if($exist){
                $new_qty = floatval($exist['qty']) + floatval($data_input['qty']);
                $new_total = floatval($exist['total']) + floatval($data_input['total']);
                $this->db->where('id', $exist['id'])
                        ->update('t_transaksi_detail', [
                            'qty' => $new_qty,
                            'total' => $new_total,
                            'updated_date' => date('Y-m-d H:i:s'),
                            'updated_by' => $this->general_library->getId()
                        ]);
            } else {
                $this->db->insert('t_transaksi_detail', $data_input);
            }

            $new_total_biaya = floatval($transaksi['total_biaya']) + floatval($data_input['total']);

            $this->db->where('id', $transaksi['id'])
                    ->update('t_transaksi', ['total_biaya' => $new_total_biaya, 'updated_by' => $this->general_library->getId(), 'updated_date' => date('Y-m-d H:i:s')]);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } 
            else {
                $this->db->trans_commit();
                return ['new_total_biaya' => $new_total_biaya];
            }
        }

        public function loadDetailTransaksi($id){
            return $this->db->select('b.nama_item, a.harga_per_item, a.qty, a.total, a.id, a.id_t_transaksi, a.catatan, a.flag_merge')
                            ->from('t_transaksi_detail a')
                            ->join('m_item_barang b', 'a.id_m_item_barang = b.id')
                            ->where('a.flag_active', 1)
                            ->where('a.id_t_transaksi', $id)
                            ->order_by('a.updated_date', 'desc')
                            ->get()->result_array();
        }

        public function deleteDetailTransaksi($id){
            $detail_transaksi = $this->db->select('*')
                                        ->from('t_transaksi_detail')
                                        ->where('id', $id)
                                        ->where('flag_active', 1)
                                        ->get()->row_array();
                                        
            $transaksi = $this->db->select('*')
                                    ->from('t_transaksi')
                                    ->where('id', $detail_transaksi['id_t_transaksi'])
                                    ->where('flag_active', 1)
                                    ->get()->row_array();

            $this->db->trans_begin();

            $this->db->where('id', $id)
                    ->update('t_transaksi_detail', ['updated_by' => $this->general_library->getId(), 'flag_active' => 0]);
            
            $new_total_biaya = floatval($transaksi['total_biaya']) - floatval($detail_transaksi['total']);

            $this->db->where('id', $transaksi['id'])
                    ->update('t_transaksi', ['updated_by' => $this->general_library->getId(), 'total_biaya' => $new_total_biaya, 'updated_date' => date('Y-m-d H:i:s')]);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } 
            else {
                $this->db->trans_commit();
                // return ['new_total_biaya' => $this->updateTotalBiayaTransaksi()];
                return ['new_total_biaya' => $new_total_biaya];
            }
        }

        public function updateTotalBiayaTransaksi($id_t_transaksi){
            $dt = $this->db->select('SUM(total) as total')
                            ->from('t_transaksi_detail')
                            ->where('id_t_transaksi', $id_t_transaksi)
                            ->where('flag_active', 1)
                            ->get()->row_array();
            
            $this->db->where('id', $id_t_transaksi)
                    ->update('t_transaksi', [
                        'updated_by' => $this->general_library->getId(), 
                        'total_biaya' => $dt['total']
                    ]);

            return $dt['total'];
        }

        public function modalUpdateItemDetailTransaksi($id){
            return $this->db->select('b.nama_item, a.harga_per_item, a.qty, a.total, a.id, a.id_m_item_barang, a.id_t_transaksi, a.catatan')
                            ->from('t_transaksi_detail a')
                            ->join('m_item_barang b', 'a.id_m_item_barang = b.id')
                            ->where('a.id', $id)
                            ->where('a.flag_active', 1)
                            ->get()->row_array();
        }

        public function updateItemBarang($data){
            if($data['catatan'] == ''){
                $data['catatan'] = null;
            }
            $data['harga_per_item'] = clearString($data['harga_per_item']);
            $data['total'] = clearString($data['total']);
            $data['updated_by'] = $this->general_library->getId();
            $id_t_transaksi = $data['id_t_transaksi'];
            $detail_transaksi = $this->db->select('*')
                                        ->from('t_transaksi_detail')
                                        ->where('id', $data['id'])
                                        ->where('flag_active', 1)
                                        ->get()->row_array();

            // $transaksi = $this->db->select('*')
            //                     ->from('t_transaksi')
            //                     ->where('id', $detail_transaksi['id_t_transaksi'])
            //                     ->where('flag_active', 1)
            //                     ->get()->row_array();

            $exist = $this->db->select('*')
                            ->from('t_transaksi_detail')
                            ->where('harga_per_item', $data['harga_per_item'])
                            ->where('id_m_item_barang', $data['id_m_item_barang'])
                            ->where('catatan', $data['catatan'])
                            ->where('id_t_transaksi', $detail_transaksi['id_t_transaksi'])
                            ->where('id !=', $data['id'])
                            ->where('flag_active', 1)
                            ->get()->row_array();
            // dd($exist);
            $this->db->trans_begin();
            
            unset($data['id_t_transaksi']);
            unset($data['id_m_item_barang']);

            if($exist){
                //hilangkan yang lama
                $this->db->where('id', $data['id'])
                        ->update('t_transaksi_detail', ['flag_active' => 0, 'updated_by' => $this->general_library->getId()]);
                unset($data['id']);

                //merge dengan yang baru
                $data['qty'] = floatval($exist['qty']) + floatval($data['qty']);
                $data['total'] = floatval($exist['total']) + floatval($data['total']);

                $this->db->where('id', $exist['id'])
                        ->update('t_transaksi_detail', $data);
            } else {
                $this->db->where('id', $detail_transaksi['id'])
                        ->update('t_transaksi_detail', $data);
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } 
            else {
                $this->db->trans_commit();
                return ['new_total_biaya' => $this->updateTotalBiayaTransaksi($id_t_transaksi)];
            }
        }

        public function deleteTransaksi($id){
            $this->db->where('id', $id)
                    ->update('t_transaksi', ['flag_active' => 0, 'updated_by' => $this->general_library->getId()]);

            $this->db->where('id_t_transaksi', $id)
                    ->update('t_transaksi_detail', ['flag_active' => 0, 'updated_by' => $this->general_library->getId()]);
        }

        public function loadPembayaran($id_t_transaksi){
            return $this->db->select('*')
                            ->from('t_pembayaran')
                            ->where('flag_active', 1)
                            ->order_by('tanggal_pembayaran', 'desc')
                            ->get()->result_array();
        }
        
        public function createPembayaran($data){
            $data_update_transaksi['new_total_biaya'] = $data['new_total_biaya'];
            $data_update_transaksi['new_total_biaya_after_diskon'] = $data['new_total_biaya_after_diskon'];
            $data_update_transaksi['status'] = 2;
            unset($data['new_total_biaya']);
            unset($data['new_total_biaya_after_diskon']);
            $transaksi = $this->db->select('*')
                                ->from('t_transaksi', $data['id_t_transaksi'])
                                ->where('flag_active', 1)
                                ->get()->row_array();

            $this->db->trans_begin();

            $data['nomor_transaksi'] = KODE_TRANSAKSI_PEMBAYARAN.$transaksi['nomor_transaksi'];

            $this->db->where('id', $data['id_t_transaksi'])
                    ->update('t_transaksi', $data_update_transaksi);
            
            $this->db->insert('t_pembayaran', $data);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } 
            else {
                $this->db->trans_commit();
            }
        }

        public function deletePembayaran($id_t_pembayaran, $id_t_transaksi){
            $this->db->trans_begin();
            
            $this->db->where('id', $id_t_transaksi)
                    ->update('t_transaksi', [
                        'new_total_biaya' => 0,
                        'new_total_biaya_after_diskon' => 0,
                        'status' => 1,
                        'updated_by' => $this->general_library->getId(),
                    ]);

            $this->db->where('id', $id_t_pembayaran)
                    ->update('t_pembayaran', [
                        'flag_active' => 0,
                        'updated_by' => $this->general_library->getId(),
                    ]);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } 
            else {
                $this->db->trans_commit();
            }
        }

        public function getTransaksiForMerge($id = 0){
            $current_transaksi = $this->db->select('*')
                                        ->from('t_transaksi')
                                        ->where('id', $id)
                                        ->where('flag_active', 1)
                                        ->get()->row_array();

            if($current_transaksi){
                $result = $this->db->select('*')
                ->from('t_transaksi')
                ->where('status !=', '2')
                ->where('id !=', $id)
                ->where('flag_active', 1)
                ->where('DATE(tanggal_transaksi)', formatDateOnlyForEdit($current_transaksi['tanggal_transaksi']))
                ->order_by('tanggal_transaksi', 'desc')
                ->get()->result_array();

                $transaksi_merge = $this->db->select('*')
                ->from('t_transaksi')
                ->where('id_transaksi_merge', $current_transaksi['id'])
                ->order_by('tanggal_transaksi', 'desc')
                ->get()->result_array();
                return [$result, $current_transaksi, $transaksi_merge];
            } else {
                return null;
            }
        }

        public function mergeBill($id_merge, $parent_id){
            $result['code'] = 0;
            $result['message'] = 'Merge Berhasil';
            $result['new_total'] = 0;

            $parent = $this->db->select('*')
                                ->from('t_transaksi')
                                ->where('id', $parent_id)
                                ->where('flag_active', 1)
                                ->get()->row_array();

            $merge = $this->db->select('*')
                                ->from('t_transaksi')
                                ->where('id', $id_merge)
                                ->where('flag_active', 1)
                                ->get()->row_array();

            if(!$parent || !$merge){
                $result['code'] = 1;
                $result['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_begin();
                $merge_detail = $this->db->select('*')
                ->from('t_transaksi_detail')
                ->where('id_t_transaksi', $merge['id'])
                ->where('flag_active', 1)
                ->get()->result_array();
                if(!$merge_detail){
                    $result['code'] = 1;
                    $result['message'] = 'Terjadi Kesalahan';
                } else {
                    $new_detail = null;
                    $i = 0;
                    foreach($merge_detail as $md){
                        $new_detail[$i]['id_t_transaksi'] = $parent['id'];
                        $new_detail[$i]['id_m_item_barang'] = $md['id_m_item_barang'];
                        $new_detail[$i]['qty'] = $md['qty'];
                        $new_detail[$i]['harga_per_item'] = $md['harga_per_item'];
                        $new_detail[$i]['total'] = $md['total'];
                        $new_detail[$i]['flag_merge'] = 1;
                        $i++;
                    }
                    $this->db->insert_batch('t_transaksi_detail', $new_detail);

                    $this->db->where('id', $merge['id'])
                    ->update('t_transaksi', [
                        'flag_active' => 0,
                        'flag_merge' => 1,
                        'id_transaksi_merge' => $parent['id'],
                        'updated_by' => $this->general_library->getId(),
                    ]);

                    $this->db->where('id_t_transaksi', $merge['id'])
                    ->update('t_transaksi_detail', [
                        'flag_active' => 0,
                        'updated_by' => $this->general_library->getId(),
                    ]);

                    $new_total_tagihan = floatval($parent['total_biaya']) + floatval($merge['total_biaya']);
                    $result['new_total'] = $new_total_tagihan;
                    $this->db->where('id', $parent['id'])
                    ->update('t_transaksi', [
                        'total_biaya' => $new_total_tagihan,
                        'updated_by' => $this->general_library->getId(),
                    ]);
                }
                if($this->db->trans_status() == FALSE){
                    $this->db->trans_rollback();
                    $result['code'] = 1;
                    $result['message'] = 'Terjadi Kesalahan';
                } else {
                    $this->db->trans_commit();
                }
            }
            return $result;
        }

        public function deleteMerge($id_merge, $parent_id){
            $result['code'] = 0;
            $result['message'] = 'Delete Merge Berhasil';
            $result['new_total'] = 0;

            $parent = $this->db->select('*')
                                ->from('t_transaksi')
                                ->where('id', $parent_id)
                                ->where('flag_active', 1)
                                ->get()->row_array();

            $merge = $this->db->select('*')
                                ->from('t_transaksi')
                                ->where('id', $id_merge)
                                // ->where('flag_active', 1)
                                ->get()->row_array();

            if(!$parent || !$merge){
                $result['code'] = 1;
                $result['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_begin();

                $this->db->where('id', $merge['id'])
                ->update('t_transaksi', [
                    'flag_active' => 1,
                    'flag_merge' => 0,
                    'id_transaksi_merge' => 0,
                    'updated_by' => $this->general_library->getId(),
                ]);

                $this->db->where('id_t_transaksi', $merge['id'])
                ->update('t_transaksi_detail', [
                    'flag_active' => 1,
                    'updated_by' => $this->general_library->getId(),
                ]);

                $this->db->where('id_t_transaksi', $parent['id'])
                ->where('flag_merge', 1)
                ->update('t_transaksi_detail', [
                    'flag_active' => 0,
                    'updated_by' => $this->general_library->getId(),
                ]);

                $new_total_tagihan = floatval($parent['total_biaya']) - floatval($merge['total_biaya']);
                $result['new_total'] = $new_total_tagihan;
                $this->db->where('id', $parent['id'])
                    ->update('t_transaksi', [
                        'total_biaya' => $new_total_tagihan,
                        'updated_by' => $this->general_library->getId(),
                    ]);
                
                if($this->db->trans_status() == FALSE){
                    $this->db->trans_rollback();
                    $result['code'] = 1;
                    $result['message'] = 'Terjadi Kesalahan';
                } else {
                    $this->db->trans_commit();
                }
            }
            return $result;
        }
	}
?>