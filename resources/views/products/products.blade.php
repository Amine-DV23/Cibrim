@extends('layouts.app')

@section('content')
    <div class="contnr01">


        <div id="modal" class="modal-overlay"
            style="display: none; position: fixed; top: 5%; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5);">
            <div class="plusopen"
                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #191C24; padding: 20px; width: calc(100% - 200px); max-width: 600px;">
                <h1>Manage Products</h1>

                <!-- Form for adding a new product -->
                <form id="product-form" action="{{ url('/products') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="product_id" name="product_id" /> <!-- حقل مخفي لـ product_id -->
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

        <div style="position: fixed; top: 30%; right: 40px; transform: translateY(-50%); text-align: center;">
            <div style="font-weight: bold; color: #166beb; margin-bottom: 5px;">
                Add-product
            </div>

            <a id="open-modal"
                style="cursor: pointer; background-color: #191C24; padding: 6px 10px; border-radius: 50%; border: #166beb solid 1px; color: #166beb; display: inline-block;">
                <i class="fa fa-plus"></i>
            </a>
        </div>

        <!-- Search Box -->
        <form class="d-none d-md-flex ms-4">
            <input style="max-width: 200px" class="form-control bg-dark border-0" type="search" id="search-box"
                placeholder="Search by name..." onkeyup="filterProducts()" />
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



            window.deleteProduct = function(id) {

                $.ajax({
                    url: '/products/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // إرسال CSRF Token للحماية
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
            };


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
                document.getElementById('submit-btn').innerText = 'Update Product'; // تغيير الزر إلى تحديث منتج
                form.method = 'POST';


                $('#product_id').val(id); // تعيين الـ product_id

                var methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);


                $('#modal').fadeIn();
            };


            $(document).mouseup(function(e) {
                var modalContent = $(".plusopen"); // العنصر الداخلي للنافذة
                if (!modalContent.is(e.target) && modalContent.has(e.target).length === 0) {
                    $('#modal').fadeOut(); // إخفاء النافذة
                }
            });


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
                            location.reload(); // تحديث الصفحة بعد إضافة أو تعديل المنتج
                        }
                    },
                    error: function() {
                        alert('There was an error processing your request.');
                    }
                });
            });


            function showMessage(message, color) {
                var messageDiv = $('#message');
                messageDiv.text(message);
                messageDiv.css('background-color', color);
                messageDiv.css('display', 'block');
                setTimeout(function() {
                    messageDiv.fadeOut();
                }, 3000);
            }



        });

        function filterProducts() {

            var searchTerm = document.getElementById('search-box').value.toLowerCase();


            var rows = document.querySelectorAll('table tbody tr');


            rows.forEach(function(row) {
                var productName = row.cells[1].innerText.toLowerCase();


                if (productName.startsWith(searchTerm)) {
                    row.style.display = ''; // Show row
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });
        }
    </script>
@endsection
