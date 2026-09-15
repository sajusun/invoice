<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Invoice Preview - {{$invoice_data['invoice_number']}}</title>
</head>
<body class="print:bg-white">
<div class="flex print:hidden">
    <div class="action-buttons p-3 flex items-end">
        <button class="bg-blue-400 hover:bg-blue-500 text-white text-sm py-2.5 px-5 mr-2 mb-2 rounded-sm transition duration-300"
           href="#" data-title="Print" onclick="window.print()">
            <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
            Print
        </button>
        <button class="bg-red-400 hover:bg-red-500 text-white text-sm py-2.5 px-5 mr-2 mb-2 rounded-sm transition duration-300"
           href="#" data-title="PDF" onclick="downloadPDF()">
            <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
            Export
        </button>
    </div>
</div>
@auth()
    @include('pages.preview.preview2')
@else
    @include('pages.preview.guest_preview')
@endauth
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function downloadPDF() {
        const element = document.getElementById('printable');
        html2pdf().from(element).set({
            margin: 0.5,
            filename: 'invoice-{{$invoice_data['invoice_number']}}.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        }).save();
    }
</script>

</html>

{{--{{$invoice_data['name']}}--}}
