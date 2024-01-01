@if (session()->has('success'))
    <div id="success-message" class="alert alert-success text-center" style="width: 600px ; margin: auto;">
        {{ session('success') }}
    </div>
    <script>
        $(document).ready(function() {
            // Add a delay and fade out effect to the success message
            $('#success-message').delay(2000).fadeOut(500);
        });
    </script>
@endif
