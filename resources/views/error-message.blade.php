@if (session()->has('error'))
    <div class="alert alert-danger text-center" id="error-message" style="width: 600px ; margin: auto;">
        {{ session('error') }}
    </div>
    <script>
        $(document).ready(function() {
            // Add a delay and fade out effect to the success message
            $('#error-message').delay(2000).fadeOut(500);
        });
    </script>
@endif
