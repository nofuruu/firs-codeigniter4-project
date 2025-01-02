<?php

namespace App\Controllers;

use App\Models\pendaftaranModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class userController extends BaseController
{
    protected $pendaftaranModel;

    public function __construct()
    {

        $this->pendaftaranModel = new pendaftaranModel();
    }

    public function index()
{
    $keyword = $this->request->getGet('keyword');
    $orderBy = $this->request->getGet('orderBy') ?? 'id';
    $orderDir = $this->request->getGet('orderDir') ?? 'ASC';

    if ($keyword) {
        $subscriptions = $this->pendaftaranModel->searchWithOrder($keyword, $orderBy, $orderDir);
    } else {
        $subscriptions = $this->pendaftaranModel->orderBy($orderBy, $orderDir)->findAll();
    }

    if ($this->request->isAJAX()) {
        return $this->response->setJSON($subscriptions);
    }

    $data = [
        'subscriptions' => $subscriptions,
        'keyword' => $keyword,
        'orderBy' => $orderBy,
        'orderDir' => $orderDir,
    ];

    return view('v_user', $data);
}

    public function import()
    {
        $file = $this->request->getFile('file');
    
        if ($file->isValid() && !$file->hasMoved()) {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet();
    
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                if ($rowIndex == 3) continue; // Skip header row
    
                // Skip empty rows (rows with no data in relevant columns)
                $username = $sheet->getCell('B' . $rowIndex)->getValue();
                if (empty($username)) continue;
    
                // Adjust the column letters based on the provided table order
                $username = $sheet->getCell('B' . $rowIndex)->getValue(); // Username in column B
                $nama_lengkap = $sheet->getCell('C' . $rowIndex)->getValue(); // Nama Lengkap in column C
                $status = $sheet->getCell('D' . $rowIndex)->getValue(); // Status in column D
                $paket_detail = $sheet->getCell('E' . $rowIndex)->getValue(); // Detail Paket in column E
    
                $paket_select = 'default_package'; 
    
                $username = $username ?? '';
                $nama_lengkap = $nama_lengkap ?? '';
                $status = $status ?? '';
                $paket_detail = $paket_detail ?? '';
    
                $data = [
                    'username' => $username,
                    'password' => '', // Default password value
                    'nama_lengkap' => $nama_lengkap,
                    'status' => $status,
                    'paket_detail' => $paket_detail,
                    'paket_select' => $paket_select, // Add 'paket_select' here
                ];
    
                $this->pendaftaranModel->insert($data);
            }
    
            return redirect()->to('/userController')->with('success', 'Data successfully imported!');
        } else {
            return redirect()->to('/userController')->with('error', 'Invalid file upload.');
        }
    }
    
    

    public function export()
{
    // Fetch data from the model
    $subscriptions = $this->pendaftaranModel->findAll();

    // Create a new Spreadsheet
    $spreadSheet = new Spreadsheet();
    $sheet = $spreadSheet->getActiveSheet();

    // Set the title and header format
    $sheet->setCellValue('A1', "Data Langganan MyInternet");
    $sheet->mergeCells('A1:E1'); // Adjust the merge range to match columns (no extra columns like paket_select)
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

    // Header columns (Row 3)
    $sheet->setCellValue('A3', "No");
    $sheet->setCellValue('B3', "Username");
    $sheet->setCellValue('C3', "Nama Lengkap");
    $sheet->setCellValue('D3', "Status");
    $sheet->setCellValue('E3', "Detail Paket");

    // Set the style for the header (Bold and centered)
    $sheet->getStyle('A3:E3')->getFont()->setBold(true);
    $sheet->getStyle('A3:E3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A3:E3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    // Write data to the sheet
    $row = 4; // Start from row 4 for data
    foreach ($subscriptions as $key => $subscription) {
        // Only export rows with data
        if (empty($subscription['username']) && empty($subscription['nama_lengkap']) && empty($subscription['status']) && empty($subscription['paket_detail'])) {
            continue;
        }

        $sheet->setCellValue('A' . $row, $key + 1);
        $sheet->setCellValue('B' . $row, $subscription['username']);
        $sheet->setCellValue('C' . $row, $subscription['nama_lengkap']);
        $sheet->setCellValue('D' . $row, $subscription['status']);
        $sheet->setCellValue('E' . $row, $subscription['paket_detail']);

        $row++;
    }

    // Set column widths to auto size
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);

    // Set borders for the data
    $sheet->getStyle('A3:E' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    // Save file as Excel
    $writer = new Xlsx($spreadSheet);
    $filename = 'data_langganan_' . date('Ymd_His') . '.xlsx';

    // Output the file to the browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    // Save the file and output
    $writer->save('php://output');
}
    
    // Tambah atau Update data
    public function tambah()
    {
        // Validasi input
        if (!$this->validate([
            'username' => 'required',
            'password' => 'required',
            'nama_lengkap' => 'required',
            'paket_select' => 'required',
        ])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Input tidak valid.'
            ]);
        }
    
        $id = $this->request->getPost('id');
        $subscriptionData = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'status' => $this->request->getPost('status'),
            'paket_select' => $this->request->getPost('paket_select'),
            'paket_detail' => implode(', ', $this->request->getPost('paket_detail') ?? []),
        ];
    
        if ($id) {
            // Update existing record
            $this->pendaftaranModel->update($id, $subscriptionData);
            $message = 'Data berhasil diperbarui.';
        } else {
            // Insert new record
            $this->pendaftaranModel->insert($subscriptionData);
            $message = 'Data berhasil disimpan.';
        }
    
        $newSubscription = $this->pendaftaranModel->find($id ? $id : $this->pendaftaranModel->getInsertID());
    
        // Return JSON
        return $this->response->setJSON([
            'success' => true,
            'message' => $message,
            'subscription' => $newSubscription,
        ]);
    }



    
public function edit($id)
{
    $subscription = $this->pendaftaranModel->find($id);

    if (!$subscription) {
        return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan!']);
    }

    return $this->response->setJSON(['success' => true, 'data' => $subscription]);
}




    // Hapus data
    public function delete($id)
    {
        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID tidak valid.']);
        }
    
        $deleted = $this->pendaftaranModel->delete($id);
    
        if ($deleted) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data.']);
        }
    }

    public function search(){
        $keyword = $this->request->getGet(('keyword'));
        $subscriptions = $this->pendaftaranModel->like('username', $keyword)
        ->orLike('nama_lengkap', $keyword)
        ->orLike('stauts', $keyword)
        ->orLike('paket_detail', $keyword)
        ->findAll();

        return $this->response->setJSON(['subscriptions' => $subscriptions]);
    }

    }
    







    

