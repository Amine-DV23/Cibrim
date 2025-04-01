@extends('layouts.app')

@section('content')
    <div class="contnr01">


        <div id="modal" class="modal-overlay">
            <div class="plusopen">
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


                <br>
            </div>
        </div>

        <!-- Clients List -->
        <h2>Clients List</h2>

        <br>

        <div style="position: fixed; top: 30%; right: 40px; transform: translateY(-50%); text-align: center;">
            <div style="font-weight: bold; color: #166beb; margin-bottom: 5px;">
                Add-Client
            </div>


            <a id="open-modal"
                style="cursor: pointer; background-color: #191C24; padding: 6px 10px; border-radius: 50%; border: #166beb solid 1px; color: #166beb; display: inline-block;">
                <i class="fa fa-plus"></i>
            </a>

        </div>


        <form class="d-none d-md-flex ms-4">
            <input style="max-width: 200px" class="form-control bg-dark border-0" type="search" id="search-box-client"
                placeholder="Search by name..." onkeyup="filterClients()">
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
        <!-- Message -->
        <div id="message" style="display:none;" class="message"></div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function filterClients() {
            var searchTerm = document.getElementById('search-box-client').value.toLowerCase();
            var rows = document.querySelectorAll('#clients-table tbody tr');

            rows.forEach(function(row) {
                var clientName = row.cells[0].innerText.toLowerCase();
                row.style.display = clientName.startsWith(searchTerm) ? '' : 'none';
            });
        }


        $('#open-modal').click(function() {

            $('#client_id').val('');
            $('#name').val('');
            $('#phone').val('');
            $('#address').val('');
            $('#submit-btn').text('Add Client');

            $('#modal').addClass('modal-show');
        });




        $('#modal').click(function(event) {

            if ($(event.target).is('#modal')) {
                $('#modal').removeClass('modal-show');
            }
        });



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
                    $('#modal').removeClass('modal-show');

                    location.reload();
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
                $('#modal').addClass('modal-show');
            });
        }

        function deleteClient(id) {
            $.ajax({
                url: '/clients/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    $('#product-' + id).remove();
                    showMessage('product deleted successfully!', 'red');
                    location.reload();
                },
                error: function() {
                    showMessage('product deleted successfully!', 'red');
                    location.reload();
                }
            });
        }

        function showMessage(message, color) {
            var messageDiv = $('#message');
            messageDiv.text(message);
            messageDiv.css('background-color', color);
            messageDiv.css('display', 'block');
            setTimeout(function() {
                messageDiv.fadeOut();
            }, 3000);
        }
    </script>
@endsection
