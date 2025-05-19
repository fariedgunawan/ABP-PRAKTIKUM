<!-- resources/views/users/index.blade.php -->
<table id="users-table">
    <thead>
        <tr><th>Name</th><th>Email</th></tr>
    </thead>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("users.index") }}',
        columns: [
            { data: 'name' },
            { data: 'email' }
        ]
    });
});
</script>
