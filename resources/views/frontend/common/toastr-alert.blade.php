@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            let msg = "{{session('success')}}";
            Tost(msg,'success');
        });
    </script>
@endif
@if (session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            let msg = "{{session('error')}}";
            Tost(msg,'error');
        });
    </script>
@endif
@if (session('info'))
    <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            let msg = "{{session('info')}}";
            Tost(msg,'info');
        });
    </script>
@endif
@if (session('warning'))
    <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            let msg = "{{session('warning')}}";
            Tost(msg,'warning');
        });
    </script>
@endif

@foreach ($errors->all() as $error)
    <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            let msg = "{{$errors->first()}}";
            // Tost(msg,'error');
        });
    </script>
@endforeach