@include('concert.ticket')
<script>
    window.addEventListener('DOMContentLoaded', () => {
        // Automatically trigger print dialog when download endpoint is invoked directly
        setTimeout(() => {
            window.print();
        }, 500);
    });
</script>
