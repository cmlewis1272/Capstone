<?php

require("fpdf/fpdf.php");
include "includes/db.php";

define('border', 1);
define('no_border', 0);

define('right', 0);
define('next_line', 1);
define('below', 2);

define('left_align', 'L');
define('Center', 'C');
define('right_align', 'R');

define('fill_background', true);
define('no_fill_background', false);

$id = $_GET['Donatorid'];

//database information to fill in the reciept
$query = "SELECT * FROM donators WHERE Donator_id = $id";
$result = mysqli_query($connection, $query);
$donator = mysqli_fetch_array($result);


$query = "SELECT * FROM donations WHERE Donator_id = $id";
$result = mysqli_query($connection, $query);
$donations = mysqli_fetch_array($result);




$pdf = new FPDF('L');
$pdf->AddPage();


//Cell(width,height,text,border,nextposition,textalign,backgroundfill,link)

//address
$pdf->SetFont('Arial',"", 14);
$pdf->Cell(100,10, 'The House of Esther',border,next_line);
$pdf->Cell(100,10, '123 Sounders Dr',border,next_line);
$pdf->Cell(100,10, '281-662-3215',border,next_line);

//separator
$pdf->Cell(280,20, '',no_border, next_line);

//donation reciet id line
$pdf->SetFont('Arial','b', 16);
$pdf->Cell(100,10, 'DONATION RECEIPT',no_border,next_line);

//separator
$pdf->Cell(280,15, '',no_border, next_line);

//Donated by donators information
$pdf->SetFont('Arial',"b", 14);
$pdf->Cell(50,10, 'Donated by: ',border,right);
$pdf->SetFont('Arial',"", 14);

//decide output for name or organization name
if ($donator["Organization_name"] != ""){
	$pdf->Cell(100,10, $donator["Organization_name"] ,border,next_line);
}else{
	$pdf->Cell(100,10, $donator["Donator_FirstName"]." ".$donator["Donator_LastName"] ,border,next_line);
}


$pdf->Cell(50,10,'',border,right);
$pdf->Cell(100,10, $donator["Street_num"]." ".$donator["Street_name"]." ".$donator["City"].", ".$donator["State"].". ".$donator["zip"] ,border,next_line);
$pdf->SetFont('Arial',"b", 14);
$pdf->Cell(50,10, 'Donation: ',border,right);
$pdf->SetFont('Arial',"", 14);
$pdf->Cell(100,10,"$".$donations['Donation_amount'],border,next_line);
$pdf->SetFont('Arial',"b", 14);
$pdf->Cell(50,10, 'Donation Recieved:',border,right);
$pdf->SetFont('Arial',"", 14);
$date = date_create($donations['Donation_date']);
$pdf->Cell(100,10, date_format($date, "m/d/Y"),border,next_line);

//separator
$pdf->Cell(280,15, '',no_border, next_line);
$pdf->Cell(280,10, 'The House of Esther is a registered 501(c)(3) nonprofit organization, EIN #####',border,next_line);




$pdf->Output();


?>