@error('systemerror')
    <script type="text/javascript">
        __toastr("{{ $message }}", "Hiba", "error");
        Swal.fire({
            title: 'Oops!',
            text: "{{ $message }}",
            icon: 'error',
            timer: 5000
        })
    </script>
@enderror
