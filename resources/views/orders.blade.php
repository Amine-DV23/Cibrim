@extends('layouts.app')

@section('content')
    <div class="contnr01">
        <h1>Add New Order</h1>

        <div class="row">
            <select id="clientSelect">
                <option value="">Select Client</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" data-phone="{{ $client->phone }}">{{ $client->name }}</option>
                @endforeach
            </select>
            <input type="date" id="currentDate" />
            <input type="text" placeholder="Phone" id="clientPhone" readonly />
        </div>

        <div id="productRows">
            <div class="row">
                <select class="productSelect">
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <input type="number" placeholder="Price" class="priceInput" step="1" readonly />
                <input type="number" placeholder="Quantity" class="quantityInput" step="1" />
                <input type="number" placeholder="Total" class="totalPriceInput" readonly />
            </div>
        </div>

        <div class="add-button" onclick="addRow()">➕</div>

        <div class="total-price-order">
            <label>Total Order Price</label>
            <input type="text" id="orderTotalPrice" readonly />
        </div>

        <div class="buttons">
            <button type="button" id="submitOrderBtn" onclick="submitOrder()">Add Order</button>
        </div>
        <input type="hidden" id="editingOrderId" value="">

        <hr>
        <h1>All Orders</h1>
        <table id="ordersTable" border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Order Date</th>
                    <th>Order ID</th>
                    <th>Client Name</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr data-order-id="{{ $order->id }}" data-client-id="{{ $order->client_id }}"
                        data-product-id="{{ $order->product_id }}" data-quantity="{{ $order->quantity }}"
                        data-price="{{ $order->product->price ?? 0 }}" data-total="{{ $order->total_price }}"
                        data-date="{{ $order->order_date }}">

                        <td>{{ $order->order_date }}</td>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->client->name ?? 'N/A' }}</td>
                        <td>{{ $order->product->name ?? 'N/A' }}</td>
                        <td>{{ $order->product->price ?? 0 }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->total_price }}</td>
                        <td>
                            <button class="editBtn" style="background-color: green;border-radius: 5px;">Edit</button>
                            <button class="deleteBtn"
                                style="background-color: rgb(128, 4, 0);border-radius: 5px;">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById("currentDate").valueAsDate = new Date();

        document.getElementById("clientSelect").addEventListener("change", function() {
            const selected = this.options[this.selectedIndex];
            document.getElementById("clientPhone").value = selected.getAttribute("data-phone");
        });

        function calculateRow(row) {
            const price = parseFloat(row.querySelector(".priceInput").value) || 0;
            const quantity = parseFloat(row.querySelector(".quantityInput").value) || 0;
            row.querySelector(".totalPriceInput").value = (price * quantity).toFixed(2);
            updateTotalOrderPrice();
        }

        function updateTotalOrderPrice() {
            let total = 0;
            document.querySelectorAll(".totalPriceInput").forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById("orderTotalPrice").value = total.toFixed(2);
        }

        function addRow() {
            const productOptions = document.querySelector(".productSelect").innerHTML;
            const row = document.createElement("div");
            row.classList.add("row");
            row.innerHTML = `
            <select class="productSelect">${productOptions}</select>
            <input type="number" placeholder="Price" class="priceInput" step="1" readonly />
            <input type="number" placeholder="Quantity" class="quantityInput" step="1" />
            <input type="number" placeholder="Total" class="totalPriceInput" readonly />
        `;
            document.getElementById("productRows").appendChild(row);

            setupRowEvents(row);
        }

        function setupRowEvents(row) {
            row.querySelector(".productSelect").addEventListener("change", function() {
                const selected = this.options[this.selectedIndex];
                const price = selected.getAttribute("data-price");
                row.querySelector(".priceInput").value = price;
                calculateRow(row);
            });

            row.querySelector(".quantityInput").addEventListener("input", function() {
                calculateRow(row);
            });
        }

        document.querySelectorAll("#productRows .row").forEach(setupRowEvents);

        function showSuccessMessage(message) {

            const messageElement = document.createElement('div');
            messageElement.classList.add('success-message');
            messageElement.innerText = message;


            document.body.appendChild(messageElement);


            setTimeout(() => {
                messageElement.style.opacity = 0;
            }, 3000);


            setTimeout(() => {
                messageElement.remove();
            }, 3500);
        }

        function submitOrder() {
            const client_id = document.getElementById("clientSelect").value;
            const order_date = document.getElementById("currentDate").value;
            const orders = [];

            document.querySelectorAll("#productRows .row").forEach(row => {
                const product_id = row.querySelector(".productSelect").value;
                const quantity = row.querySelector(".quantityInput").value;
                const total_price = row.querySelector(".totalPriceInput").value;

                if (product_id && quantity && total_price) {
                    orders.push({
                        product_id,
                        quantity,
                        total_price
                    });
                }
            });

            if (!client_id || orders.length === 0) {
                alert("Please fill all required fields.");
                return;
            }

            const orderId = document.getElementById("editingOrderId").value;

            const method = orderId ? "PUT" : "POST";
            const url = orderId ? `/orders/update/${orderId}` : "/orders";

            fetch(url, {
                    method: method,
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        client_id,
                        order_date,
                        orders: orders
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showSuccessMessage(orderId ? "Order Updated!" : "Order Saved!");
                        setTimeout(() => {
                            location.reload();
                        }, 3500);
                    }
                });
        }


        let editing = false;

        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const orderId = row.dataset.orderId;
                const clientId = row.dataset.clientId;
                const productId = row.dataset.productId;
                const quantity = row.dataset.quantity;
                const price = row.dataset.price;
                const total = row.dataset.total;
                const date = row.dataset.date;


                document.getElementById('clientSelect').value = clientId;
                document.getElementById('currentDate').value = date;
                document.getElementById('clientPhone').value = document.querySelector(
                    `#clientSelect option[value="${clientId}"]`)?.dataset.phone || '';


                const firstRow = document.querySelector("#productRows .row");
                firstRow.querySelector(".productSelect").value = productId;
                firstRow.querySelector(".priceInput").value = price;
                firstRow.querySelector(".quantityInput").value = quantity;
                firstRow.querySelector(".totalPriceInput").value = total;

                document.getElementById("orderTotalPrice").value = total;


                document.getElementById("submitOrderBtn").innerText = "Update Order";
                document.getElementById("editingOrderId").value = orderId;
                editing = true;
            });
        });

        document.querySelectorAll('.deleteBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const orderId = row.dataset.orderId;


                fetch(`/orders/delete/${orderId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showSuccessMessage();
                            row.remove();
                        }
                    });
            });
        });
    </script>

    <style>
        .success-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: green;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
            z-index: 9999;
        }
    </style>
@endsection
