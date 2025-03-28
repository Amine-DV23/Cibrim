@extends('layouts.app')

@section('content')
    <div class="contnr01">
        <h1>Add New Clients</h1>

        <form>
            <div class="form-row">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" placeholder="Enter name" name="name" />
                </div>

                <div class="input-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" placeholder="Enter phone" name="phone" />
                </div>
            </div>

            <div class="address-group">
                <label for="address">Address</label>
                <textarea id="address" placeholder="Enter address" name="address"></textarea>
            </div>

            <div class="buttons">
                <button type="submit">Add Client</button>
            </div>
        </form>
    </div>
@endsection
