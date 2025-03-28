@extends('layouts.app')

@section('content')
    <div class="contnr01">

        <h1>Add New Order</h1>

        <div class="row">
            <select>
                <option>clirent</option>
            </select>
            <input type="date" id="currentDate" value="" />
            <input type="text" placeholder="phone" />
        </div>
        <div id="productRows">
            <div class="row">
                <select>
                    <option>product</option>
                </select>
                <input type="number" placeholder="price" id="price0" step="0.01" oninput="calculateTotalPrice(0)" />
                <input type="number" placeholder="quantity" id="quantity0" step="0.01"
                    oninput="calculateTotalPrice(0)" />
                <input type="number" placeholder="total price" id="totalPrice0" readonly />
            </div>
        </div>
        <div class="add-button" onclick="addRow()">➕</div>

        <div class="buttons">
            <button type="submit">Add Order</button>
        </div>
        <div class="total-price-order">
            <label>total price order</label>
            <input type="text" id="orderTotalPrice" readonly />
        </div>

    </div>

    <script>
        // Set current date in the date field
        document.getElementById("currentDate").valueAsDate = new Date();

        // Function to calculate total price for each row
        function calculateTotalPrice(index) {
            const price =
                parseFloat(document.getElementById(`price${index}`).value) || 0;
            const quantity =
                parseFloat(document.getElementById(`quantity${index}`).value) || 0;
            const totalPrice = price * quantity;
            document.getElementById(`totalPrice${index}`).value =
                totalPrice.toFixed(2);

            updateOrderTotal();
        }

        // Function to update the total order price
        function updateOrderTotal() {
            let totalOrderPrice = 0;
            const totalPrices = document.querySelectorAll("[id^='totalPrice']");
            totalPrices.forEach((totalPriceInput) => {
                const totalPrice = parseFloat(totalPriceInput.value) || 0;
                totalOrderPrice += totalPrice;
            });

            document.getElementById("orderTotalPrice").value =
                totalOrderPrice.toFixed(2);
        }

        // Function to add a new row when the "+" button is clicked
        function addRow() {
            const rowIndex = document.querySelectorAll(".row").length;
            const newRow = document.createElement("div");
            newRow.classList.add("row");
            newRow.innerHTML = `
          <select>
            <option>product</option>
          </select>
          <input type="number" placeholder="price" id="price${rowIndex}" step="0.01" oninput="calculateTotalPrice(${rowIndex})" />
          <input type="number" placeholder="quantity" id="quantity${rowIndex}" step="0.01" oninput="calculateTotalPrice(${rowIndex})" />
          <input type="number" placeholder="total price" id="totalPrice${rowIndex}" readonly />
        `;
            document.getElementById("productRows").appendChild(newRow);
        }
    </script>
@endsection
