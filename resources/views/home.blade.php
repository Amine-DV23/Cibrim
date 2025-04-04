@extends('layouts.app')

@section('content')
    <div class="contnr01">

        <div class="container">

            <h1>Welcome to Order Management System</h1>


            <div class="grid-container">

                <a href="clients" class="grid-item">
                    <div class="icon">👥</div>
                    <div class="title">Add Client</div>
                    <p class="description">Manage client information and their purchase history</p>
                </a>
                <a href="orders" class="grid-item">
                    <div class="icon">📜</div>
                    <div class="title">Add Order</div>
                    <p class="description">View all orders and update their statuses easily</p>
                </a>
                <a href="products" class="grid-item">
                    <div class="icon">📋</div>
                    <div class="title">Add Product</div>
                    <p class="description">Manage and update product information in the store</p>
                </a>
                <a href="home" class="grid-item">
                    <div class="icon">📞</div>
                    <div class="title">Contact</div>
                    <p class="description">Contact support or get help with system issues</p>
                </a>
                <a href="home" class="grid-item">
                    <div class="icon">📦</div>
                    <div class="title">Customer Orders</div>
                    <p class="description">Manage customer orders and track their statuses</p>
                </a>
                <a href="home" class="grid-item">
                    <div class="icon">🛒</div>
                    <div class="title">Show Products</div>
                    <p class="description">Show a detailed list of available products</p>
                </a>
            </div>
        </div>
    </div>
@endsection
