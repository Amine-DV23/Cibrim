@extends('layouts.app')

@section('content')
    <div class="contnr01">


        <div id="modal" class="modal-overlay"
            style="display: none; position: fixed; top: 5%; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5);">
            <div class="plusopen"
                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);border-radius: 10px; background-color: #2b2b2b; padding: 20px; width: calc(100% - 200px); max-width: 600px;">
                <h1>Manage Products</h1>

                <!-- Form for adding a new product -->
                <form id="product-form" action="{{ url('/products') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="product_id" name="product_id" />
                    <div class="form-row">
                        <div>
                            <label for="name">Name:</label>
                            <input type="text" id="name" placeholder="Enter name" name="name" required />
                        </div>
                        <div>
                            <label for="price">Price:</label>
                            <input type="text" id="price" placeholder="Enter Price" name="price" required />
                        </div>
                    </div>

                    <label for="description">Description:</label>
                    <textarea id="description" placeholder="Enter Description" name="description" required></textarea>

                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" />

                    <div class="buttons">
                        <button type="submit" id="submit-btn">Add Product</button>
                    </div>
                </form>

                <br>

            </div>
        </div>

        <h2>Products List</h2>

        <br>


        <div class="pluss">


            <div style="font-weight: bold; color: #166beb; margin-bottom: 5px;">
                Add-Product
            </div>


            <a id="open-modal" class="pluss2">
                <i class="fa fa-plus"></i>
            </a>

        </div>


        <br>

        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr id="product-{{ $product->id }}">
                        <td>
                            @if ($product->image)
                                <img src="{{ asset('images/' . $product->image) }}" alt="Product Image" width="50" />
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->description }}</td>

                        <td>
                            <button class="update-btn" onclick="editProduct({{ $product->id }})">Edit</button>
                            <button class="delete-btn" onclick="deleteProduct({{ $product->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#open-modal').click(function() {

                $('#product_id').val('');
                $('#name').val('');
                $('#price').val('');
                $('#description').val('');
                $('#image').val('');


                $('#submit-btn').text('Add Product');


                $('#product-form').attr('action', '{{ url('/products') }}');
                $('#product-form').attr('method', 'POST');


                $('input[name="_method"]').remove();

                $('#modal').fadeIn();
            });



            window.editProduct = function(id) {
                var row = document.getElementById('product-' + id);
                var name = row.cells[1].innerText;
                var price = row.cells[2].innerText;
                var description = row.cells[3].innerText;

                document.getElementById('name').value = name;
                document.getElementById('price').value = price;
                document.getElementById('description').value = description;

                var form = document.getElementById('product-form');
                form.action = '/products/' + id;
                document.getElementById('submit-btn').innerText = 'Update Product';
                form.method = 'POST';


                $('#product_id').val(id);

                var methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);


                $('#modal').fadeIn();
            };

            window.deleteProduct = function(id) {
                showSpinner();
                $.ajax({
                    url: '/products/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#product-' + id).remove();
                        showErrorMessage();
                        location.reload();
                    },
                    error: function() {
                        showErrorMessage();
                        location.reload();
                    },
                    complete: function() {
                        hideSpinner();
                    }
                });
            };



            $(document).mouseup(function(e) {
                var modalContent = $(".plusopen");
                if (!modalContent.is(e.target) && modalContent.has(e.target).length === 0) {
                    $('#modal').fadeOut();
                }
            });


            $('#product-form').submit(function(e) {
                e.preventDefault();
                showSpinner();
                var formData = new FormData(this);
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        showSuccessMessage();
                        if (response.status === 'success') {
                            location.reload();
                        }
                    },
                    error: function() {
                        alert('There was an error processing your request.');
                    },
                    complete: function() {
                        hideSpinner();
                    }
                });
            });






        });

        function filterProducts() {

            var searchTerm = document.getElementById('search-box').value.toLowerCase();


            var rows = document.querySelectorAll('table tbody tr');


            rows.forEach(function(row) {
                var productName = row.cells[1].innerText.toLowerCase();


                if (productName.startsWith(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
    <script src="js/main.js"></script>
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
