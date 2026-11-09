@php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $layout = 'layouts.layout';
  
@endphp

@extends($layout)

@section('title', 'Dashboard')

@section('content_page')
    <main class="app-main" id="main" tabindex="-1">

                        <div class="app-content-header">

                            <div class="container-fluid">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <h1 class="mb-0 fs-3">Dashboard v2</h1>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </main>
@endsection

@section('js_content')
    <script>
        $(document).ready(function() {
            // Your JavaScript code here
        });
    </script>
@endsection