<?php
	class M_Laporan extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function searchLaporanTransaksi($data){
            $result = null;
            $total_tagihan = 0;
            $jumlah_orang = 0;
            list($tanggal_awal, $tanggal_akhir) = explodeRangeDate($data['range_tanggal']);
            $this->db->select('a.*')
                    ->from('t_transaksi a')
					// ->join('t_pembayaran b', 'a.id = b.id_t_transaksi')
                    ->where('a.flag_active', 1)
                    ->where('a.tanggal_transaksi >=', $tanggal_awal.' 00:00:00')
                    ->where('a.tanggal_transaksi <=', $tanggal_akhir.' 23:59:59')
                    ->order_by('a.tanggal_transaksi', 'desc');
            if($data['nomor_transaksi'] != ''){
                $this->db->where('a.nomor_transaksi', $data['nomor_transaksi']);
            }
            if($data['jenis_transaksi'] != 0){
                $this->db->where('a.jenis_transaksi', $data['jenis_transaksi']);
            }
            if($data['status'] != 0){
                $this->db->where('a.status', $data['status']);
            }
            $result = $this->db->get()->result_array();
            if($result){
                foreach($result as $r){
                    $total_tagihan += $r['total_biaya'];
                    $jumlah_orang += $r['jumlah_orang'];
                }
            }
            return [$result, $total_tagihan, $jumlah_orang];
        }

        public function searchRekapHarian($data){
            $this->db->query(
                'UPDATE t_pembayaran a
                SET a.tanggal_pembayaran =
                (SELECT b.tanggal_transaksi
                FROM t_transaksi b
                WHERE a.id_t_transaksi = b.id
                AND b.flag_active = 1
                LIMIT 1)
                WHERE a.tanggal_pembayaran = "0000-00-00 00:00:00"'
            );

            list($tanggal_awal, $tanggal_akhir) = explodeRangeDate($data['range_tanggal']);
            $kategori = null;
            $sub_kategori = null;
            $item = null;
            $jumlah_orang = 0;
            $jumlah_item = 0;
            $transaksi = null;
            $total_transaksi = 0;
            $total_pembayaran = 0;
            $pengeluaran = null;
            $total_pengeluaran = 0;
            $pembelian = null;
            $total_pembelian = 0;
            
            $temp_transaksi = $this->db->select('*')
                                ->from('t_transaksi')
                                ->where('flag_active', 1)
                                ->where('tanggal_transaksi >=', $tanggal_awal.' 00:00:00')
                                ->where('tanggal_transaksi <=', $tanggal_akhir.' 23:59:59')
                                ->order_by('tanggal_transaksi', 'desc')
                                ->get()->result_array();
            if($temp_transaksi){
                foreach($temp_transaksi as $tt){
                    $total_transaksi += floatval($tt['total_biaya']);
                    $jumlah_orang += floatval($tt['jumlah_orang']);
                    $transaksi[$tt['id']] = $tt;
                    $transaksi[$tt['id']]['detail_transaksi'] = null;
                }
            }
            $temp_kategori = $this->db->select('id, nama_kategori')
                                ->from('m_kategori_barang')
                                ->where('flag_active', 1)
                                ->get()->result_array();
            foreach($temp_kategori as $tk){
                $kategori[$tk['id']] = $tk;
                $kategori[$tk['id']]['jumlah'] = 0;
            }
            $temp_sub_kategori = $this->db->select('id, nama_sub_kategori, id_m_kategori_barang')
                                ->from('m_sub_kategori_barang')
                                ->where('flag_active', 1)
                                ->get()->result_array();
            foreach($temp_sub_kategori as $tsk){
                $sub_kategori[$tsk['id']] = $tsk;
                $sub_kategori[$tsk['id']]['jumlah'] = 0;
            }

            $rekap = $this->db->select('a.*, e.*, b.nama_item, c.id as id_m_sub_kategori_barang, d.id as id_m_kategori_barang')
                                ->from('t_transaksi_detail a')
                                ->join('m_item_barang b', 'a.id_m_item_barang = b.id')
                                ->join('m_sub_kategori_barang c', 'b.id_m_sub_kategori_barang = c.id')
                                ->join('m_kategori_barang d', 'c.id_m_kategori_barang = d.id')
                                ->join('t_transaksi e', 'a.id_t_transaksi = e.id')
                                ->where('a.flag_active', 1)
                                ->where('b.flag_active', 1)
                                ->where('e.tanggal_transaksi >=', $tanggal_awal.' 00:00:00')
                                ->where('e.tanggal_transaksi <=', $tanggal_akhir.' 23:59:59')
                                ->get()->result_array();
            if($rekap){
                foreach($rekap as $r){
                    $jumlah_item += floatval($r['qty']);
                    $kategori[$r['id_m_kategori_barang']]['jumlah'] = floatval($kategori[$r['id_m_kategori_barang']]['jumlah']) + floatval($r['qty']);
                    $sub_kategori[$r['id_m_sub_kategori_barang']]['jumlah'] = floatval($sub_kategori[$r['id_m_sub_kategori_barang']]['jumlah']) + floatval($r['qty']);
                }
            }
            
            $item = $this->db->select('c.id, c.nama_item, sum(b.qty) as jumlah, b.harga_per_item, e.id as id_kategori_barang, d.id as id_sub_kategori_barang')
                            ->from('t_transaksi a')
                            ->join('t_transaksi_detail b', 'a.id = b.id_t_transaksi')
                            ->join('m_item_barang c', 'b.id_m_item_barang = c.id')
                            ->join('m_sub_kategori_barang d', 'c.id_m_sub_kategori_barang = d.id')
                            ->join('m_kategori_barang e', 'd.id_m_kategori_barang = e.id')
                            ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            ->where('e.flag_active', 1)
                            ->where('a.tanggal_transaksi >=', $tanggal_awal.' 00:00:00')
                            ->where('a.tanggal_transaksi <=', $tanggal_akhir.' 23:59:59')
                            ->group_by('c.id, b.harga_per_item')
                            ->get()->result_array();

            $pembayaran = $this->db->select('a.*, b.nomor_transaksi, a.nomor_transaksi as nomor_pembayaran, b.total_biaya')
                                    ->from('t_pembayaran a')
                                    ->join('t_transaksi b', 'a.id_t_transaksi = b.id')
                                    ->where('a.flag_active', 1)
                                    ->order_by('a.tanggal_pembayaran')
                                    ->where('tanggal_pembayaran >=', $tanggal_awal.' 00:00:00')
                                    ->where('tanggal_pembayaran <=', $tanggal_akhir.' 23:59:59')
                                    ->get()->result_array();
            if($pembayaran){
                foreach($pembayaran as $p){
                    $total_pembayaran += floatval($p['jumlah_pembayaran']) - floatval($p['kembalian']);
                }
            }

            $pengeluaran = $this->db->select('*, c.nama_pengeluaran as nama_jenis_pengeluaran')
                                    ->from('t_pengeluaran a')
                                    ->join('t_pengeluaran_detail b', 'a.id = b.id_t_pengeluaran')
                                    ->join('m_jenis_pengeluaran c', 'c.id = b.id_m_jenis_pengeluaran')
                                    ->where('a.flag_active', 1)
                                    ->where('b.flag_active', 1)
                                    ->where('a.tanggal_pengeluaran >=', $tanggal_awal.' 00:00:00')
                                    ->where('a.tanggal_pengeluaran <=', $tanggal_akhir.' 23:59:59')
                                    ->order_by('b.created_date', 'desc')
                                    ->get()->result_array();
            if($pengeluaran){
                foreach($pengeluaran as $peng){
                    $total_pengeluaran += floatval($peng['total_harga']);
                }
            }

            $pembelian = $this->db->select('*, c.nama_pembelian as nama_jenis_pembelian')
                                    ->from('t_pembelian a')
                                    ->join('t_pembelian_detail b', 'a.id = b.id_t_pembelian')
                                    ->join('m_jenis_pembelian c', 'c.id = b.id_m_jenis_pembelian')
                                    ->where('a.flag_active', 1)
                                    ->where('b.flag_active', 1)
                                    ->where('a.tanggal_pembelian >=', $tanggal_awal.' 00:00:00')
                                    ->where('a.tanggal_pembelian <=', $tanggal_akhir.' 23:59:59')
                                    ->order_by('b.created_date', 'desc')
                                    ->get()->result_array();
            if($pembelian){
                foreach($pembelian as $peng){
                    $total_pembelian += floatval($peng['total_harga']);
                }
            }
            function sortByOrder($a, $b) {
                return $b['jumlah'] - $a['jumlah'];
            }
            usort($kategori, 'sortByOrder');
            usort($sub_kategori, 'sortByOrder');
            usort($item, 'sortByOrder');

            return [$kategori, $sub_kategori, $item, $jumlah_item, $jumlah_orang, $transaksi, $total_transaksi, $pembayaran,
            $total_pembayaran, $rekap, $pengeluaran, $total_pengeluaran, $pembelian, $total_pembelian];
        }

        public function searchLaporanPenjualan($data){
            list($tanggal_awal, $tanggal_akhir) = explodeRangeDate($data['range_tanggal']);
            $total_biaya = 0;
            $this->db->select('a.*, a.created_date as tanggal_input_item, e.*, b.nama_item, c.id as id_m_sub_kategori_barang, d.id as id_m_kategori_barang, 
            c.nama_sub_kategori, d.nama_kategori')
                    ->from('t_transaksi_detail a')
                    ->join('m_item_barang b', 'a.id_m_item_barang = b.id')
                    ->join('m_sub_kategori_barang c', 'b.id_m_sub_kategori_barang = c.id')
                    ->join('m_kategori_barang d', 'c.id_m_kategori_barang = d.id')
                    ->join('t_transaksi e', 'a.id_t_transaksi = e.id')
                    ->where('a.flag_active', 1)
                    ->where('e.flag_active', 1)
                    ->where('e.tanggal_transaksi >=', $tanggal_awal.' 00:00:00')
                    ->where('e.tanggal_transaksi <=', $tanggal_akhir.' 23:59:59')
                    ->order_by('a.created_date', 'desc');
            if($data['id_m_kategori_barang'] != 0){
                $this->db->where('d.id', $data['id_m_kategori_barang']);
            }
            if($data['id_m_sub_kategori_barang'] != 0){
                $this->db->where('c.id', $data['id_m_sub_kategori_barang']);
            }
            if($data['id_m_item_barang'] != 0){
                $this->db->where('a.id_m_item_barang', $data['id_m_item_barang']);
            }
            $result = $this->db->get()->result_array();
            if($result){
                foreach($result as $r){
                    $total_biaya += floatval($r['total_biaya']);
                };
            }
            return [$result, $total_biaya];
        }

        public function searchLaporanPembayaran($data){
            $total_tagihan = 0;
            $total_pembayaran = 0;
            list($tanggal_awal, $tanggal_akhir) = explodeRangeDate($data['range_tanggal']);

            $this->db->select('a.*, b.nomor_transaksi, a.nomor_transaksi as nomor_pembayaran, b.total_biaya')
                        ->from('t_pembayaran a')
                        ->join('t_transaksi b', 'a.id_t_transaksi = b.id')
                        ->where('a.flag_active', 1)
                        ->where('tanggal_pembayaran >=', $tanggal_awal.' 00:00:00')
                        ->where('tanggal_pembayaran <=', $tanggal_akhir.' 23:59:59')
                        ->order_by('a.tanggal_pembayaran', 'desc');
            if($data['nomor_pembayaran'] != ""){
                $this->db->like('a.nomor_transaksi', $data['nomor_pembayaran']);
            }
            if($data['nama_pembayar'] != ""){
                $this->db->like('a.nama_pembayar', $data['nama_pembayar']);
            }
            if($data['cara_bayar'] != "0"){
                $this->db->where('a.cara_bayar', $data['cara_bayar']);
            }
            $result = $this->db->get()->result_array();
            if($result){
                foreach($result as $r){
                    $total_tagihan += floatval($r['total_biaya']);
                    $total_pembayaran += floatval($r['jumlah_pembayaran']);
                }
            }
            return [$result, $total_tagihan, $total_pembayaran];
        }

        public function cetakRekap($data, $params_search){
            list($tanggal_awal, $tanggal_akhir) = explodeRangeDate($params_search['range_tanggal']);

            $this->db->select('c.nama_item, b.id_t_transaksi, a.tanggal_transaksi, b.qty, e.id as id_kategori, d.id as id_sub_kategori, c.id as id_item, b.total, b.catatan, b.harga_per_item')
                    ->from('t_transaksi a')
                    ->join('t_transaksi_detail b', 'a.id = b.id_t_transaksi')
                    ->join('m_item_barang c', 'b.id_m_item_barang = c.id')
                    ->join('m_sub_kategori_barang d', 'c.id_m_sub_kategori_barang = d.id')
                    ->join('m_kategori_barang e', 'd.id_m_kategori_barang = e.id')
                    ->where('a.tanggal_transaksi >=', $tanggal_awal.' 00:00:00')
                    ->where('a.tanggal_transaksi <=', $tanggal_akhir.' 23:59:59')
                    ->where('b.flag_active', 1)
                    ->where('a.flag_active', 1)
                    ->group_by('b.id')
                    ->order_by('total', 'desc');
            $result = $this->db->get()->result_array();
            $final_result = null;
            if(isset($data['kategori'])){
                // $this->db->where_in('e.id', $data['kategori']);
                if($data['kategori'][0] != 'semua_kategori'){
                    foreach($result as $rs){
                        if(in_array($rs['id_kategori'], $data['kategori'])){
                            $final_result[] = $rs;
                        }
                    }
                } else {
                    $final_result = null;
                    $final_result = $result;
                    return $final_result;
                }
                
            }
            if(isset($data['sub_kategori'])){
                // $this->db->where_in('d.id', $data['sub_kategori']);
                if($data['sub_kategori'][0] != 'semua_sub_kategori'){
                    foreach($result as $rs){
                        if(in_array($rs['id_sub_kategori'], $data['sub_kategori'])){
                            $final_result[] = $rs;
                        }
                    }
                } else {
                    $final_result = null;
                    $final_result = $result;
                    return $final_result;
                }
            }
            if(isset($data['item'])){
                // $this->db->where_in('c.id', $data['item']);
                if($data['item'][0] != 'semua_item'){
                    foreach($result as $rs){
                        if(in_array($rs['id_item'], $data['item'])){
                            $final_result[] = $rs;
                        }
                    }
                } else {
                    $final_result = null;
                    $final_result = $result;
                    return $final_result;
                }
            }
            return $final_result;
        }

        public function cetakRekap2($data, $params_search){
            list($tanggal_awal, $tanggal_akhir) = explodeRangeDate($params_search['range_tanggal']);
            $final_result = null;
            $result = $this->db->select('b.nomor_transaksi, b.nama, b.nomor_meja, b.jumlah_orang, a.tanggal_pembayaran, b.jenis_transaksi, a.diskon_nominal, a.diskon_presentase,
                                    b.new_total_biaya_after_diskon, a.jumlah_pembayaran, a.kembalian, a.id_t_transaksi')
                                    ->from('t_pembayaran a')
                                    ->join('t_transaksi b', 'a.id_t_transaksi = b.id')
                                    ->where('a.flag_active', 1)
                                    ->where('b.flag_active', 1)
                                    ->where('b.tanggal_transaksi >=', $tanggal_awal.' 00:00:00')
                                    ->where('b.tanggal_transaksi <=', $tanggal_akhir.' 23:59:59')
                                    ->order_by('a.tanggal_pembayaran')
                                    ->group_by('b.id')
                                    ->get()->result_array();
            if($data['id_transaksi']){
                if($data['id_transaksi'][0] != 'semua_transaksi'){
                    foreach($result as $rs){
                        if(in_array($rs['id_t_transaksi'], $data['id_transaksi'])){
                            $final_result[$rs['id_t_transaksi']] = $rs;
                        }
                    }
                } else {
                    foreach($result as $rs){
                        $final_result[$rs['id_t_transaksi']] = $rs;
                    }
                }
            }
            if($final_result){
                $detail_transaksi = $this->db->select('a.*, b.nama_item')
                                            ->from('t_transaksi_detail a')
                                            ->join('m_item_barang b', 'a.id_m_item_barang = b.id')
                                            ->where_in('a.id_t_transaksi', $data['id_transaksi'])
                                            ->order_by('a.created_date', 'asc')
                                            ->where('a.flag_active', 1)
                                            ->group_by('a.id')
                                            ->get()->result_array();
                if($detail_transaksi){
                    foreach($detail_transaksi as $d){
                        $final_result[$d['id_t_transaksi']]['detail_item'][] = $d;
                    }
                }
            }
            return $final_result;
        }

        public function saveRekapItem($data, $params_search){
            list($tanggal_awal, $tanggal_akhir) = explodeRangeDate($params_search['range_tanggal']);
            $this->db->select('c.id, c.nama_item, sum(b.qty) as jumlah, b.harga_per_item, e.id as id_kategori_barang, d.id as id_sub_kategori_barang')
                    ->from('t_transaksi a')
                    ->join('t_transaksi_detail b', 'a.id = b.id_t_transaksi')
                    ->join('m_item_barang c', 'b.id_m_item_barang = c.id')
                    ->join('m_sub_kategori_barang d', 'c.id_m_sub_kategori_barang = d.id')
                    ->join('m_kategori_barang e', 'd.id_m_kategori_barang = e.id')
                    ->where('a.flag_active', 1)
                    ->where('b.flag_active', 1)
                    ->where('e.flag_active', 1)
                    ->where('a.tanggal_transaksi >=', $tanggal_awal.' 00:00:00')
                    ->where('a.tanggal_transaksi <=', $tanggal_akhir.' 23:59:59')
                    ->group_by('c.id, b.harga_per_item');
            if($data['id_transaksi']){
                if($data['id_transaksi'][0] != 'semua_transaksi'){
                    $this->db->where_in('a.id', $data['id_transaksi']);
                }
            }
            $item = $this->db->get()->result_array();

            if($item){
                function sortByOrder($a, $b) {
                    return $b['jumlah'] - $a['jumlah'];
                }
                usort($item, 'sortByOrder');        
            }
        
            return $item;
        }
	}
?>