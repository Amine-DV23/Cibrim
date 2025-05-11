@extends('layouts.app')

@section('content')
    <div class="contnr01">

        <div id="modal" class="modal-overlay"
            style="display: none; position: fixed; top: 5%; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5);">
            <div class="plusopen"
                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);border-radius: 10px; background-color: #2b2b2b; padding: 20px; width: calc(100% - 200px); max-width: 600px;">
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

        <div class="pluss">
            <div style="font-weight: bold; color: #166beb; margin-bottom: 5px;">
                Add-Client
            </div>
            <a id="open-modal" class="pluss2">
                <i class="fa fa-plus"></i>
            </a>
        </div>

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
                            <button onclick="editClient({{ $client->id }})" class="update-btn">Edit</button>
                            <button onclick="deleteClient({{ $client->id }})" class="delete-btn">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#open-modal').click(function() {
            $('#client_id').val('');
            $('#name').val('');
            $('#phone').val('');
            $('#address').val('');
            $('#submit-btn').text('Add Client');
            $('#modal').css('display', 'block');
        });


        $('#modal').click(function(event) {
            if ($(event.target).is('#modal')) {
                $('#modal').css('display', 'none');
            }
        });


        $('#client-form').on('submit', function(e) {
            e.preventDefault();
            const id = $('#client_id').val();
            const url = id ? `/clients/${id}` : '/clients';
            const method = id ? 'PUT' : 'POST';

            showSpinner();

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
                    hideSpinner();
                    showSuccessMessage();
                    $('#modal').css('display', 'none');
                    location.reload();
                },
                error: function(xhr) {
                    hideSpinner();
                    showErrorMessage();
                    alert('An error occurred while saving');
                }
            });
        });


        function editClient(id) {
            showSpinner();
            $.get(`/clients/${id}`, function(data) {
                hideSpinner();
                $('#client_id').val(data.id);
                $('#name').val(data.name);
                $('#phone').val(data.phone);
                $('#address').val(data.address);
                $('#submit-btn').text('Update Client');
                $('#modal').css('display', 'block');
            }).fail(function() {
                hideSpinner();
                showErrorMessage();
                alert('Error fetching client data');
            });
        }


        function deleteClient(id) {
            if (!confirm('Are you sure you want to delete this client?')) return;

            showSpinner();
            $.ajax({
                url: '/clients/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    hideSpinner();
                    showSuccessMessage();
                    $('#client-' + id).remove();
                    alert('Client deleted successfully!');
                    location.reload();
                },
                error: function() {
                    hideSpinner();
                    showErrorMessage();
                    alert('Error while deleting');
                    location.reload();
                }
            });
        }
    </script>
    <style>
        #modal input,
        #modal textarea {
            width: 100%;
            font-size: 12px;
            padding: 6px;
            margin-bottom: 10px;
        }

        #modal label {
            font-size: 12px;
        }

        #modal h1 {
            font-size: 16px;
            text-align: center;
            margin-bottom: 10px;
        }

        #submit-btn {
            font-size: 12px;
            padding: 6px 10px;
        }
    </style>
@endsection
