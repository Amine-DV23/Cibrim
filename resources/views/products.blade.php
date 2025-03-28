@extends('layouts.app')

@section('content')
    <div class="contnr01">

        <h1>Add New Product</h1>

        <form>
            <div class="form-row">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" placeholder="Enter name" name="name" />
                </div>
                <div>
                    <label for="price">Price:</label>
                    <input type="text" id="price" placeholder="Enter Price" name="price" />
                </div>
            </div>

            <label for="description">Description:</label>
            <textarea id="description" placeholder="Enter Description" name="description"></textarea>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" />

            <div class="buttons">
                <button type="button" onclick="showOptions()">Add-List ▼</button>
                <button type="submit">Add Product </button>
            </div>

            <div id="dropdown" class="dropdown-content">
                <p>Product1</p>
                <p>Product2</p>
                <p>Product3</p>
                <p>Product4</p>
            </div>
        </form>
    </div>

    <script>
        function showOptions() {
            var dropdown = document.getElementById("dropdown");
            dropdown.classList.toggle("show");
        }
    </script>
@endsection
