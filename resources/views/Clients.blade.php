@extends('layouts.app')

@section('content')
    <div class="contnr01">
        <h1>Add New Client</h1>

        <!-- Form -->
        <form id="client-form">
            @csrf
            <input type="hidden" id="client_id" name="client_id" />

            <div class="form-row">
                <div class="input-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter name" required />
                </div>

                <div class="input-group">
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter phone" required />
                </div>
            </div>

            <div class="address-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" placeholder="Enter address" required></textarea>
            </div>

            <div class="buttons">
                <button type="submit" id="submit-btn">Add Client</button>
            </div>
        </form>

        <!-- Flash Message -->
        <div id="message" class="message" style="display: none;"></div>

        <br>

        <!-- Clients List -->
        <h2>Clients List</h2>

        <br>

        <form class="d-none d-md-flex ms-4">
            <input style="max-width: 200px" class="form-control bg-dark border-0" type="search" id="search-box-client"
                placeholder="Search by name..."onkeyup="filterClients()">
        </form>

        <br>

        <table id="clients-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr id="client-{{ $client->id }}">
                        <td class="name">{{ $client->name }}</td>
                        <td class="phone">{{ $client->phone }}</td>
                        <td class="address">{{ $client->address }}</td>
                        <td>
                            <button onclick="editClient({{ $client->id }})"
                                style="background-color: green;border-radius: 5px;">Edit</button>
                            <button onclick="deleteClient({{ $client->id }})"
                                style="background-color: rgb(128, 4, 0);border-radius: 5px;">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to filter clients based on the first letter typed in search box
        function filterClients() {
            var searchTerm = document.getElementById('search-box-client').value.toLowerCase();

            // Get all client rows in the table
            var rows = document.querySelectorAll('#clients-table tbody tr');

            rows.forEach(function(row) {
                var clientName = row.cells[0].innerText.toLowerCase(); // Assuming name is in the first cell

                // Check if the client name starts with the search term
                if (clientName.startsWith(searchTerm)) {
                    row.style.display = ''; // Show the row
                } else {
                    row.style.display = 'none'; // Hide the row
                }
            });
        }

        // Existing functions for submitting, editing, and deleting clients
        $('#client-form').on('submit', function(e) {
            e.preventDefault();
            const id = $('#client_id').val();
            const url = id ? `/clients/${id}` : '/clients';
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: {
                    _token: '{{ csrf_token() }}',
                    name: $('#name').val(),
                    phone: $('#phone').val(),
                    address: $('#address').val()
                },
                success: function(response) {
                    showMessage(response.message, 'green');
                    setTimeout(() => location.reload(), 1000);
                },
                error: function(xhr) {
                    showMessage('Error occurred', 'red');
                }
            });
        });

        function editClient(id) {
            $.get(`/clients/${id}`, function(data) {
                $('#client_id').val(data.id);
                $('#name').val(data.name);
                $('#phone').val(data.phone);
                $('#address').val(data.address);
                $('#submit-btn').text('Update Client');
            });
        }

        // Function to delete the client silently (without confirm or alert)
        function deleteClient(id) {
            $.ajax({
                url: '/clients/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    $('#client-' + id).remove();
                    // Show a success message after deletion
                    showMessage('client deleted successfully!', 'red');

                    // Refresh the page immediately after successful deletion
                    setTimeout(function() {
                        location.reload(); // Refresh the page
                    }, 2000); // 1 second delay
                },
                error: function() {
                    // Show a success message after deletion
                    showMessage('client deleted successfully!', 'red');

                    // Refresh the page immediately after successful deletion
                    setTimeout(function() {
                        location.reload(); // Refresh the page
                    }, 2000); // 1 second delay
                }
            });
        }

        function showMessage(text, color) {
            $('#message').text(text).css({
                display: 'block',
                backgroundColor: color,
                color: '#fff',
                position: 'fixed',
                top: '50%',
                left: '50%',
                transform: 'translate(-50%, -50%)',
                padding: '15px',
                borderRadius: '10px',
                zIndex: 9999
            });

            setTimeout(() => $('#message').fadeOut(), 3000);
        }
    </script>
@endsection
