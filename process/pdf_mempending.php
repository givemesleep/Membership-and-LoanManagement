<?php 
    require_once '../cruds/config.php';
    require_once '../fdpf/fpdf.php';

    $oras = new DateTime();
    $date = $oras->format('m');

    $pdf = new FPDF();
    $pdf->AddPage();
    
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,10,'Hello World!',0,1);
    // $pdf->Image();

    $pdf->Output('F', 'pending'.$date.'.pdf');

    // header('Location : applicant_pendings.php');
    


?>