@extends('layouts.app_admin')

@section('main_admin')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8 mt-4">
            <div class="card p-4 shadow">
                <p><b>Invoice Number:</b> {{ $annual->invoice_no }}</p>
                <p><b>Invoice Date:</b> {{ $annual->invoice_date }}</p>
                <p><b>Description:</b> {{ $annual->description }}</p>
                <p><b>Amount:</b> {{ $annual->currency }} {{ $annual->amount  }}</p>
                
                @if ($annual->file)
                    @php
                        $fileUrl = asset('annuals/' . $annual->file);
                        $fileExtension = pathinfo($fileUrl, PATHINFO_EXTENSION);
                    @endphp

                    @if (in_array($fileExtension, ['xlsx', 'docx', 'pdf', 'xls', 'csv']))
                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary" style="padding: 0.2rem 0.5rem;">View File</a>
                    @else
                        <p>No preview available. <embed src="https://docs.google.com/viewer?url={{ urlencode($fileUrl) }}" style="width:100%; height:600px;" frameborder="0"></embed></p>
                    @endif
                @else
                    <p>No file attached.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
