<?php
ob_start();
session_start();
require_once "../../../backend/config.php";
require_once "../../../backend/fpdf186/fpdf.php";

class PDF extends FPDF {
    public $widths;
    public $aligns;

    function Header() {
        // ... your header code
        $this->widths = [35,15,20,20,25,18,18,20,15,30]; 
        $this->adjustWidths();

        $header = ['Full Name','Gender','Civil Status','Birthdate','Birthplace','Purok','Contact','Occupation','Voter','Email'];
        foreach($header as $i=>$col){
            $this->Cell($this->widths[$i],8,$col,1,0,'C', true);
        }
        $this->Ln();
    }
    // ... rest of class
}

// generate PDF
$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','',6.5);

$lineHeight = 4;
$residents = $residentsCollection->find();
foreach($residents as $r){
    $user = $usersCollection->findOne(["_id"=>$r->user_id]);
    if (($user->status ?? "Pending") !== 'Approved') continue;
    $fullName = trim($r->first_name." ".($r->middle_name ?? '')." ".$r->last_name." ".($r->suffix ?? ''));
    $row = [
        $fullName,
        $r->gender ?? '',
        $r->civil_status ?? '',
        $r->birthdate ?? '',
        $r->birthplace ?? '',
        $r->purok ?? '',
        $r->contact ?? '',
        $r->occupation ?? '',
        $r->voter ?? 'No',
        $r->email ?? '',
    ];
    $pdf->Row($row, $lineHeight);
}

$pdf->Output('I','Residents_List.pdf');
ob_end_flush();
