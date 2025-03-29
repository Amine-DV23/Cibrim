@extends('layouts.app')

@section('content')
    <div class="contnr01">
        <h1>Manage Products</h1>

        <!-- Form for adding a new product -->
        <form id="product-form" action="{{ url('/products') }}" method="POST" enctype="multipart/form-data">
            @csrf
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

        <h2>Products List</h2>

        <br>
        <!-- Search Box -->
        <form class="d-none d-md-flex ms-4">
            <input style="max-width: 200px" class="form-control bg-dark border-0" type="search" id="search-box"
                placeholder="Search by name..."onkeyup="filterProducts()" />
        </form>
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
                            <button style="background-color: green;border-radius: 5px;"
                                onclick="editProduct({{ $product->id }})">Edit</button>
                            <button style="background-color: rgb(128, 4, 0);border-radius: 5px;"
                                onclick="deleteProduct({{ $product->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Message -->
        <div id="message" style="display:none;" class="message"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showOptions() {
            var dropdown = document.getElementById("dropdown");
            dropdown.classList.toggle("show");
        }


        // Function to edit the product data
        function editProduct(id) {
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

            var methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
        }

        // Function to delete the product silently and show success message
        function deleteProduct(id) {
            $.ajax({
                url: '/products/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // Remove the deleted product row
                    $('#product-' + id).remove();

                    // Show a success message after deletion
                    showMessage('Product deleted successfully!', 'red');

                    // Refresh the page immediately after successful deletion
                    setTimeout(function() {
                        location.reload(); // Refresh the page
                    }, 2000); // 1 second delay
                },
                error: function() {
                    // Show a success message after deletion
                    showMessage('Product deleted successfully!', 'red');

                    // Refresh the page immediately after successful deletion
                    setTimeout(function() {
                        location.reload(); // Refresh the page
                    }, 2000); // 1 second delay
                }
            });
        }

        // Function to show the message
        function showMessage(message, color) {
            var messageDiv = $('#message');
            messageDiv.text(message);
            messageDiv.css('background-color', color);
            messageDiv.css('display', 'block');
            setTimeout(function() {
                messageDiv.fadeOut();
            }, 3000);
        }

        // Submit the form using AJAX for adding/updating product
        $('#product-form').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    showMessage(response.message, 'green');
                    if (response.status === 'success') {
                        location.reload(); // Refresh the page after adding or updating
                    }
                },
                error: function() {
                    alert('There was an error processing your request.');
                }
            });
        });


        // Function to filter products based on the first letter typed in search box
        function filterProducts() {
            // Get the search term and convert it to lowercase
            var searchTerm = document.getElementById('search-box').value.toLowerCase();

            // Get all product rows
            var rows = document.querySelectorAll('table tbody tr');

            // Loop through all rows and hide or show based on search term
            rows.forEach(function(row) {
                var productName = row.cells[1].innerText.toLowerCase();

                // Check if the product name starts with the search term
                if (productName.startsWith(searchTerm)) {
                    row.style.display = ''; // Show row
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });
        }

        // Existing functions (editProduct, deleteProduct, etc.)
    </script>
@endsection
