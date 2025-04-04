@extends('layouts.app')

@section('content')
    <div class="contnr01">

        <div id="modal" class="modal-overlay">
            <div class="plusopen">
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
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}
                                </option>
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

                <br>
            </div>
        </div>

        <h1>All Orders</h1>
        <br>

        <div class="pluss">


            <div style="font-weight: bold; color: #166beb; margin-bottom: 5px;">
                Add-Order
            </div>


            <a id="open-modal" class="pluss2">
                <i class="fa fa-plus"></i>
            </a>

        </div>

        <form class="d-none d-md-flex ms-4">
            <input style="max-width: 200px" class="form-control bg-dark border-0" type="search" id="search-box-order"
                placeholder="Search by name..." onkeyup="filterOrders()">
        </form>

        <br>
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
                @php
                    $groupNumbers = [];
                    $currentNumber = 1;
                @endphp

                @foreach ($orders->reverse() as $order)
                    @php
                        $groupId = $order->order_group_id;

                        if (!isset($groupNumbers[$groupId])) {
                            $groupNumbers[$groupId] = $currentNumber++;
                        }
                    @endphp

                    <tr data-order-id="{{ $order->id }}" data-client-id="{{ $order->client_id }}"
                        data-product-id="{{ $order->product_id }}" data-quantity="{{ $order->quantity }}"
                        data-price="{{ $order->product->price ?? 0 }}" data-total="{{ $order->total_price }}"
                        data-date="{{ $order->order_date }}">

                        <td>{{ $order->order_date }}</td>
                        <td>{{ $order->order_group_id }}</td>
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
        <div id="message" style="display:none;" class="message"></div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("modal");
            const openModalBtn = document.getElementById("open-modal");
            const submitOrderBtn = document.getElementById("submitOrderBtn");
            const editingOrderId = document.getElementById("editingOrderId");


            openModalBtn.addEventListener("click", function() {
                modal.style.display = "flex";
                editingOrderId.value = ""; // التأكد من أن الـ orderId فارغ عند إضافة طلب جديد
                submitOrderBtn.innerText = "Add Order"; // إعادة النص إلى "Add Order"


                document.getElementById('clientSelect').value = ""; // إعادة تعيين العميل
                document.getElementById('clientPhone').value = ""; // إعادة تعيين الهاتف


                document.querySelectorAll("#productRows .row").forEach(row => {
                    row.querySelector(".productSelect").value = ""; // إعادة تعيين المنتج
                    row.querySelector(".priceInput").value = ""; // إعادة تعيين السعر
                    row.querySelector(".quantityInput").value = ""; // إعادة تعيين الكمية
                    row.querySelector(".totalPriceInput").value = ""; // إعادة تعيين السعر الإجمالي
                });


                document.getElementById("orderTotalPrice").value = "0";
            });


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

                    document.getElementById("submitOrderBtn").innerText =
                        "Update Order";
                    document.getElementById("editingOrderId").value = orderId;

                    modal.style.display = "flex";
                });
            });


            submitOrderBtn.addEventListener("click", function() {
                modal.style.display = "none";
            });


            modal.addEventListener("click", function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        });


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
                        showMessage("The operation was successful.", true);
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showMessage("The operation failed ", false);
                    }
                })
                .catch(() => showMessage("The operation failed   ", false));

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

        function filterOrders() {
            let input = document.getElementById("search-box-order").value.toLowerCase();
            let rows = document.querySelectorAll("#ordersTable tbody tr");

            rows.forEach(row => {
                let clientName = row.cells[2].textContent.toLowerCase(); // اسم العميل في العمود الثالث
                if (clientName.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }



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
                            row.remove();
                            showMessage("product deleted successfully", true);
                        } else {
                            showMessage("The operation failed ", false);
                        }
                    })
                    .catch(() => showMessage(" The operation failed  ", false));

            });
        });

        function showMessage(text, success = true) {
            const messageDiv = document.getElementById("message");
            messageDiv.textContent = text;
            messageDiv.style.display = "block";
            messageDiv.style.backgroundColor = success ? "rgba(40, 167, 69, 0.8)" : "rgba(220, 53, 69, 0.8)";

            setTimeout(() => {
                messageDiv.style.display = "none";
            }, 3000); // تخفي الرسالة بعد 3 ثواني
        }
    </script>
@endsection
