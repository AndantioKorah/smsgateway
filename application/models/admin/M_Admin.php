<?php
	class M_Admin extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function searchKategori(){
            return $this->db->select('*')
                                    ->from('m_kategori_barang')
                                    ->where('flag_active', 1)
                                    ->like('nama_kategori', $value)
                                    ->get()->result_array();
        }

        public function getAllSubKategoriBarang(){
            return $this->db->select('a.*, b.nama_kategori')
                            ->from('m_sub_kategori_barang a')
                            ->join('m_kategori_barang b', 'a.id_m_kategori_barang = b.id')
                            ->where('a.flag_active', 1)
                            ->order_by('a.created_date', 'desc')
                            ->get()->result_array();
        }

        public function getAllItem(){
            return $this->db->select('a.*, c.nama_kategori, b.nama_sub_kategori')
                            ->from('m_item_barang a')
                            ->join('m_sub_kategori_barang b', 'a.id_m_sub_kategori_barang = b.id')
                            ->join('m_kategori_barang c', 'b.id_m_kategori_barang = c.id')
                            ->where('a.flag_active', 1)
                            ->order_by('a.created_date', 'desc')
                            ->get()->result_array();
        }

        public function getStockItem($id){
            $this->db->select('*')
                    ->from('t_stock_barang a')
                    ->join('m_item_barang b', 'a.id_m_item_barang = b.id')
                    ->where('a.flag_active', 1)
                    ->order_by('a.created_date', 'asc');
            if($id != "semua" && $id != "0"){
                $this->db->where('a.id_m_item_barang', $id);
            }

            return $this->db->get()->result_array();
        }

        public function otentikasiUser($data, $jenis_transaksi){
            $username = $data['username'];
            $password = $this->general_library->encrypt($username, $data['password']);
            $otentikasi = $this->db->select('*')
                                    ->from('m_user')
                                    ->where('username', $username)
                                    ->where('password', $password)
                                    ->where_in('id_m_role', [1,2])
                                    ->where('flag_active', 1)
                                    ->get()->row_array();
            if($otentikasi){
                return ['code' => $jenis_transaksi];
            }
            return ['code' => 0];
        }

        public function searchTransaksiPembelian($data){
            list($tanggal_awal, $tanggal_akhir) = explodeRangeDate($data['range_tanggal']);
            $this->db->select('*')
                    ->from('t_pembelian')
                    ->where('tanggal_pembelian >=', $tanggal_awal.' 00:00:00')
                    ->where('tanggal_pembelian <=', $tanggal_akhir.' 23:59:59')
                    ->where('flag_active', 1);
            if($data['nomor_transaksi'] != ''){
                $this->db->like('nomor_transaksi', $data['nomor_transaksi']);
            }
            if($data['nama_pembelian'] != ''){
                $this->db->like('nama_pembelian', $data['nama_pembelian']);
            }
            return $this->db->get()->result_array();
        }

        public function createTransaksiPembelian($data){
            $data['nomor_transaksi'] = KODE_TRANSAKSI_PEMBELIAN.date('dmyhis');
            $data['tanggal_pembelian'] = date('y-m-d H:i:s');
            $this->db->insert('t_pembelian', $data);
            $last_id = $this->db->insert_id();
            return ['last_id' => $last_id];
        }

        public function detailPembelian($id){
            $pembelian = null;
            $detail = null;
            $pembelian = $this->db->select('*')
                                    ->from('t_pembelian')
                                    ->where('id', $id)
                                    ->where('flag_active', 1)
                                    ->get()->row_array();
            if($pembelian){
                $detail = $this->db->select('*, a.keterangan as keterangan_detail, a.id as id_detail')
                                    ->from('t_pembelian_detail a')
                                    ->join('m_jenis_pembelian b', 'a.id_m_jenis_pembelian = b.id')
                                    ->where('a.id_t_pembelian', $id)
                                    ->where('a.flag_active', 1)
                                    ->order_by('a.created_date', 'desc')
                                    ->get()->result_array();
            }
            return [$pembelian, $detail];
        }

        public function simpanTransaksiPembelian($id, $data){
            $data['updated_by'] = $this->general_library->getId();
            $this->db->where('id', $id)
                    ->update('t_pembelian', $data);
        }

        //pengeluaran
        public function searchTransaksiPengeluaran($data){
            list($tanggal_awal, $tanggal_akhir) = explodeRangeDate($data['range_tanggal']);
            $this->db->select('*')
                    ->from('t_pengeluaran')
                    ->where('tanggal_pengeluaran >=', $tanggal_awal.' 00:00:00')
                    ->where('tanggal_pengeluaran <=', $tanggal_akhir.' 23:59:59')
                    ->where('flag_active', 1);
            if($data['nomor_transaksi'] != ''){
                $this->db->like('nomor_transaksi', $data['nomor_transaksi']);
            }
            if($data['nama_pengeluaran'] != ''){
                $this->db->like('nama_pengeluaran', $data['nama_pengeluaran']);
            }
            return $this->db->get()->result_array();
        }

        public function createTransaksiPengeluaran($data){
            $data['nomor_transaksi'] = KODE_TRANSAKSI_PENGELUARAN.date('dmyhis');
            $data['tanggal_pengeluaran'] = date('y-m-d H:i:s');
            $this->db->insert('t_pengeluaran', $data);
            $last_id = $this->db->insert_id();
            return ['last_id' => $last_id];
        }

        public function detailPengeluaran($id){
            $pengeluaran = null;
            $detail = null;
            $pengeluaran = $this->db->select('*')
                                    ->from('t_pengeluaran')
                                    ->where('id', $id)
                                    ->where('flag_active', 1)
                                    ->get()->row_array();
            if($pengeluaran){
                $detail = $this->db->select('*, a.keterangan as keterangan_detail, a.id as id_detail')
                                    ->from('t_pengeluaran_detail a')
                                    ->join('m_jenis_pengeluaran b', 'a.id_m_jenis_pengeluaran = b.id')
                                    ->where('a.id_t_pengeluaran', $id)
                                    ->where('a.flag_active', 1)
                                    ->order_by('a.created_date', 'desc')
                                    ->get()->result_array();
            }
            return [$pengeluaran, $detail];
        }

        public function simpanTransaksiPengeluaran($id, $data){
            $data['updated_by'] = $this->general_library->getId();
            $this->db->where('id', $id)
                    ->update('t_pengeluaran', $data);
        }
	}
?>