<?php
	class M_Tagihan extends CI_Model
	{
        public $bios_serial_num;

        public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function countTagihan($id_t_pendaftaran){
            $this->db->trans_begin();

            $new_total_tagihan = 0;
            $sisa_harus_bayar = 0;
            $tagihan = $this->db->select('a.*, b.id_m_cara_bayar')
                                ->from('t_tagihan a')
                                ->join('t_pendaftaran b', 'a.id_t_pendaftaran = b.id')
                                ->where('a.id_t_pendaftaran', $id_t_pendaftaran)
                                ->where('a.flag_active', 1)
                                ->limit(1)
                                ->get()->row_array();
            if($tagihan && $tagihan['id_m_status_tagihan'] == 1 && $tagihan['id_m_cara_bayar'] == 1){
                $detail_tagihan = $this->db->select('*')
                                        ->from('t_tagihan_detail')
                                        ->where('id_t_pendaftaran', $id_t_pendaftaran)
                                        ->where('flag_active', 1)
                                        ->get()->result_array();

                $pembayaran = $this->db->select('*')
                                        ->from('t_pembayaran')
                                        ->where('id_t_pendaftaran', $id_t_pendaftaran)
                                        ->where('flag_active', 1)
                                        ->limit(1)
                                        ->get()->row_array();

                $uang_muka = $this->db->select('*')
                                        ->from('t_uang_muka')
                                        ->where('id_t_pendaftaran', $id_t_pendaftaran)
                                        ->where('flag_active', 1)
                                        ->limit(1)
                                        ->get()->row_array();

                if($detail_tagihan){
                    foreach($detail_tagihan as $dt){
                        $new_total_tagihan += floatval($dt['biaya']);
                    }
                    $this->db->where('id_t_pendaftaran', $id_t_pendaftaran)
                            ->update('t_tagihan', 
                        [
                            'total_tagihan' => $new_total_tagihan,
                            'updated_by' => $this->general_library->getId()
                        ]);
                }

                $sisa_harus_bayar = $new_total_tagihan;
                if($uang_muka){
                    $sisa_harus_bayar = $sisa_harus_bayar - floatval($uang_muka['jumlah_pembayaran']);
                }
                if($pembayaran){
                    $sisa_harus_bayar = $sisa_harus_bayar - floatval($pembayaran['jumlah_pembayaran']) - floatval($pembayaran['diskon_nominal']);
                }
            }

            
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }

            return $sisa_harus_bayar;
        }

        public function getRincianTagihan($id_pendaftaran){
            $list_jns_tindakan = null;
            $data = null;
            $detail_tagihan = $this->db->select('a.*, b.id_m_nm_tindakan, c.id_m_jns_tindakan')
                                    ->from('t_tagihan_detail a')
                                    ->join('t_tindakan b', 'a.id_reference = b.id')
                                    ->join('m_tindakan c', 'b.id_m_nm_tindakan = c.id')
                                    ->where('a.id_t_pendaftaran', $id_pendaftaran)
                                    ->where('a.flag_active', 1)
                                    ->where('b.flag_active', 1)
                                    ->order_by('a.created_by', 'desc')
                                    ->get()->result_array();
            if($detail_tagihan){
                foreach($detail_tagihan as $dt){
                    $list_jns_tindakan[] = $dt['id_m_jns_tindakan'];
                }
                $list_jns_tindakan = array_unique($list_jns_tindakan);
            }

            if($list_jns_tindakan){
                $jns_tindakan = $this->db->select('*')
                                    ->from('m_jns_tindakan')
                                    ->where_in('id', $list_jns_tindakan)
                                    // ->where('flag_active', 1)
                                    ->get()->result_array();
                if($jns_tindakan){
                    foreach($jns_tindakan as $j){
                        $data[$j['id']] = $j;
                        $data[$j['id']]['total_biaya'] = 0;
                    }
                }
                foreach($detail_tagihan as $dt){
                    $data[$dt['id_m_jns_tindakan']]['total_biaya'] += $dt['biaya'];
                    $data[$dt['id_m_jns_tindakan']]['detail_tagihan'][] = $dt;
                }
            }
            return $data;
        }

        public function getRincianTagihanBu($id_pendaftaran){
            $list_parent_id = null;
            $data = null;
            $detail_tagihan = $this->db->select('a.*, c.id_m_jns_tindakan')
                                    ->from('t_tagihan_detail a')
                                    ->join('t_tindakan b', 'a.id_reference = b.id')
                                    ->join('m_tindakan c', 'b.id_m_nm_tindakan = c.id')
                                    ->where('a.id_t_pendaftaran', $id_pendaftaran)
                                    ->where('a.flag_active', 1)
                                    ->where('b.flag_active', 1)
                                    ->order_by('a.id', 'asc')
                                    ->get()->result_array();
        
            if($detail_tagihan){
                foreach($detail_tagihan as $dt){
                        $list_parent_id[] = $dt['id_m_jns_tindakan'];  
                }
                $list_parent_id = array_unique($list_parent_id);
            }
            // var_dump($list_jns_tindakan);
            // die();

            if($list_parent_id){
                $jns_tindakan = $this->db->select('a.id, a.nm_jns_tindakan')
                                    ->from('m_jns_tindakan as a')
                                    ->where_in('a.id', $list_parent_id)
                                    // ->where('a.flag_active', 1)
                                    ->get()->result_array();
                if($jns_tindakan){
                    foreach($jns_tindakan as $j){
                        $data[$j['id']] = $j;
                        $data[$j['id']]['total_biaya'] = 0;
                    }
                }
                foreach($detail_tagihan as $dt){
                    $data[$dt['id_m_jns_tindakan']]['total_biaya'][] += floatval($dt['biaya']);
                    $data[$dt['id_m_jns_tindakan']]['detail_tagihan'][] = $dt;
                }
            }
            dd($data);
            return $data;
        }
	}
?>