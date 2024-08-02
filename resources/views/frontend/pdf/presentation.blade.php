<!DOCTYPE html>
<html style="height: 100%">
    <head>
        <title>Presentation</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                margin: 0 !important;
                margin-bottom: 0 !important;
            }
        </style>
    </head>
    <body style="height:100%;">
        <div style="width:100%; height:100%;">
            <iframe id="pdfjs" src="{{ asset('assets/js/pdfjs/web/viewer.html') }}?file={{ asset('pdf/venture nz presentation.pdf') }}" style="border:none; width:100%; height:100%;"></iframe>
        </div>
    </body>
</html>
@push('scripts')
<script src="{{ asset('assets/js/pdfjs/build/pdf.js') }}"></script>
<script src="{{ asset('assets/js/pdfjs/build/pdf.worker.js') }}"></script>
@endpush
