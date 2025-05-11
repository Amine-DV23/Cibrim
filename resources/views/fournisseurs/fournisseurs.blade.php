@extends('layouts.app')

@section('content')
    <div class="contnr01">


        <div id="modal" class="modal-overlay"
            style="display: none; position: fixed; top: 5%; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5);">
            <div class="plusopen"
                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);border-radius: 10px; background-color: #2b2b2b; padding: 20px; width: calc(100% - 200px); max-width: 600px;">
                <h1>Add New fournisseur</h1>

                <!-- Form -->
                <form id="fournisseur-form">
                    @csrf
                    <input type="hidden" id="fournisseur_id" name="fournisseur_id" />

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
                        <button type="submit" id="submit-btn">Add fournisseur</button>
                    </div>
                </form>

                <br>
            </div>
        </div>

        <!-- fournisseurs List -->
        <h2>fournisseurs List</h2>
        <br>

        <div class="pluss">
            <div style="font-weight: bold; color: #166beb; margin-bottom: 5px;">
                Add-fournisseur
            </div>
            <a id="open-modal" class="pluss2">
                <i class="fa fa-plus"></i>
            </a>
        </div>

        <br>

        <table id="fournisseurs-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fournisseurs as $fournisseur)
                    <tr id="fournisseur-{{ $fournisseur->id }}">
                        <td class="name">{{ $fournisseur->name }}</td>
                        <td class="phone">{{ $fournisseur->phone }}</td>
                        <td class="address">{{ $fournisseur->address }}</td>
                        <td>
                            <button onclick="editfournisseur({{ $fournisseur->id }})" class="update-btn">Edit</button>
                            <button onclick="deletefournisseur({{ $fournisseur->id }})" class="delete-btn">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#open-modal').click(function() {
            $('#fournisseur_id').val('');
            $('#name').val('');
            $('#phone').val('');
            $('#address').val('');
            $('#submit-btn').text('Add fournisseur');
            $('#modal').css('display', 'block');
        });


        $('#modal').click(function(event) {
            if ($(event.target).is('#modal')) {
                $('#modal').css('display', 'none');
            }
        });

        $('#fournisseur-form').on('submit', function(e) {
            e.preventDefault();
            const id = $('#fournisseur_id').val();
            const url = id ? `/fournisseurs/${id}` : '/fournisseurs';
            const method = id ? 'PUT' : 'POST';

            showSpinner();

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: method,
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
                    let msg = 'An error occurred while saving';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        msg = Object.values(xhr.responseJSON.errors).join('\n');
                    }
                    alert(msg);
                }
            });
        });

        function editfournisseur(id) {
            showSpinner();

            $.get(`/fournisseurs/${id}`, function(data) {
                hideSpinner();
                $('#fournisseur_id').val(data.id);
                $('#name').val(data.name);
                $('#phone').val(data.phone);
                $('#address').val(data.address);
                $('#submit-btn').text('Update fournisseur');
                $('#modal').css('display', 'block');
            }).fail(function() {
                hideSpinner();
                showErrorMessage();
            });
        }

        function deletefournisseur(id) {
            showSpinner();

            $.ajax({
                url: '/fournisseurs/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    hideSpinner();
                    showSuccessMessage();
                    $('#fournisseur-' + id).remove();
                    alert('fournisseur deleted successfully!');
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
