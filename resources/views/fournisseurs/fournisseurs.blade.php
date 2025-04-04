@extends('layouts.app')

@section('content')
    <div class="contnr01">


        <div id="modal" class="modal-overlay">
            <div class="plusopen">
                <h1>Add New Fournisseur</h1>

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
                        <button type="submit" id="submit-btn">Add Fournisseur</button>
                    </div>
                </form>


                <br>
            </div>
        </div>

        <!-- Fournisseurs List -->
        <h2>Fournisseurs List</h2>

        <br>


        <div class="pluss">


            <div style="font-weight: bold; color: #166beb; margin-bottom: 5px;">
                Add-Fournis..
            </div>


            <a id="open-modal" class="pluss2">
                <i class="fa fa-plus"></i>
            </a>

        </div>


        <form class="d-none d-md-flex ms-4">
            <input style="max-width: 200px" class="form-control bg-dark border-0" type="search" id="search-box-fournisseur"
                placeholder="Search by name..." onkeyup="filterFournisseurs()">
        </form>

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
                            <button onclick="editFournisseur({{ $fournisseur->id }})"
                                style="background-color: green;border-radius: 5px;">Edit</button>
                            <button onclick="deleteFournisseur({{ $fournisseur->id }})"
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
        function filterFournisseurs() {
            var searchTerm = document.getElementById('search-box-fournisseur').value.toLowerCase();
            var rows = document.querySelectorAll('#fournisseurs-table tbody tr');

            rows.forEach(function(row) {
                var fournisseurName = row.cells[0].innerText.toLowerCase();
                row.style.display = fournisseurName.startsWith(searchTerm) ? '' : 'none';
            });
        }


        $('#open-modal').click(function() {

            $('#fournisseur_id').val('');
            $('#name').val('');
            $('#phone').val('');
            $('#address').val('');
            $('#submit-btn').text('Add Fournisseur');

            $('#modal').addClass('modal-show');
        });




        $('#modal').click(function(event) {

            if ($(event.target).is('#modal')) {
                $('#modal').removeClass('modal-show');
            }
        });



        $('#fournisseur-form').on('submit', function(e) {
            e.preventDefault();
            const id = $('#fournisseur_id').val();
            const url = id ? `/fournisseurs/${id}` : '/fournisseurs';
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
                    if (response.status === 'success') {
                        location.reload(); // تحديث الصفحة بعد إضافة أو تعديل المنتج
                    }
                },
                error: function() {
                    alert('There was an error processing your request.');
                }
            });
        });

        function editFournisseur(id) {
            $.get(`/fournisseurs/${id}`, function(data) {
                $('#fournisseur_id').val(data.id);
                $('#name').val(data.name);
                $('#phone').val(data.phone);
                $('#address').val(data.address);
                $('#submit-btn').text('Update Fournisseur');
                $('#modal').addClass('modal-show');
            });
        }

        function deleteFournisseur(id) {
            $.ajax({
                url: '/fournisseurs/' + id,
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
