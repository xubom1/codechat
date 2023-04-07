<?php

require('../../lib/html2pdf/vendor/autoload.php');

$obj = new Pdf();

$html = '<html><body>'
    . '<p>Put your html here, or generate it with your favourite '
    . 'templating system.</p>'
    . '</body></html>';

$invoice = $obj->generatePdf($html);

define('INVOICE_DIR', public_path('uploads/invoices'));

if (!is_dir(INVOICE_DIR)) {
    mkdir(INVOICE_DIR, 0755, true);
}

$outputName = str_random(10);
$pdfPath = INVOICE_DIR.'/'.$outputName.'.pdf';


File::put($pdfPath, $invoice);

$headers = [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' =>  'attachment; filename="'.'filename.pdf'.'"',
];

return response()->download($pdfPath, 'filename.pdf', $headers);
