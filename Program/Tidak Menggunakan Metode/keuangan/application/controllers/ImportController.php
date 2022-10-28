<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ImportController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('excel', 'session'));
        $this->load->model('ImportModel');
        require APPPATH . 'libraries/PHPExcel.php';
    }

    // public function index()
    // {
    //     $this->load->model('ImportModel');
    //     $data = array(
    //         'list_data'    => $this->ImportModel->getData()
    //     );
    //     $this->load->view('import_excel.php', $data);
    // }

    public function import_excel()
    {
        if (isset($_FILES["fileExcel"]["name"])) {
            $path = $_FILES["fileExcel"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $nim = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $nama = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $jurusan = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $kelas = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $semester = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $ta = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $tak = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $angkatan = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $email = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $id_termin = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $id_beasiswa = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $id_pembangunan = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $temp_data[] = array(
                        'nim' => $nim,
                        'nama' => $nama,
                        'jurusan' => $jurusan,
                        'kelas' => $kelas,
                        'semester' => $semester,
                        'ta' => $ta,
                        'tak' => $tak,
                        'angkatan' => $angkatan,
                        'email' => $email,
                        'id_termin' => $id_termin,
                        'id_beasiswa' => $id_beasiswa,
                        'id_pembangunan' => $id_pembangunan
                    );

                    $data_akun[] = array(
                        'username' => $nim,
                        'password' => md5($nim),
                        'level' => 2
                    );
                }
            }
            // $this->load->model('ImportModel');
            $insert = $this->ImportModel->insert($temp_data);
            $this->ImportModel->insert_akun($data_akun);
            if ($insert) {
                $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-ok"></span> Data Berhasil di Import ke Database');
                redirect('tambah_mahasiswa');
            } else {
                $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                redirect('tambah_mahasiswa');
            }
        } else {
            echo "Tidak ada file yang masuk";
        }
    }
}
