@extends('layout')

@section('content')
<div class="container">
    <h2>Users Management</h2>
    
    <!-- Form to add new user -->
    <form id="addUserForm" class="mb-3">
        <div class="input-group">
            <input type="text" id="name" class="form-control" placeholder="Name" required>
            <input type="email" id="email" class="form-control" placeholder="Email" required>
            <input type="password" id="password" class="form-control" placeholder="Password" required>
            <button type="submit" class="btn btn-primary">Add User</button>
        </div>
    </form>

    <!-- Users Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="usersTable">
            <!-- Data will be inserted here using JS -->
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetchUsers();

        // Function to fetch users
        function fetchUsers() {
            fetch("/users")
                .then(response => response.json())
                .then(users => {
                    let table = document.getElementById("usersTable");
                    table.innerHTML = "";
                    users.forEach(user => {
                        table.innerHTML += `
                            <tr>
                                <td>${user.id}</td>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm editUser" data-id="${user.id}">Edit</button>
                                    <button class="btn btn-danger btn-sm deleteUser" data-id="${user.id}">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    attachEventListeners();
                });
        }

        // Attach events to buttons
        function attachEventListeners() {
            document.querySelectorAll(".deleteUser").forEach(btn => {
                btn.addEventListener("click", function () {
                    let userId = this.getAttribute("data-id");
                    fetch(`/users/${userId}`, { method: "DELETE" })
                        .then(() => fetchUsers());
                });
            });
        }

        // Add User Form Submission
        document.getElementById("addUserForm").addEventListener("submit", function (e) {
            e.preventDefault();
            let name = document.getElementById("name").value;
            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;

            fetch("/users", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ name, email, password })
            }).then(() => {
                fetchUsers();
                document.getElementById("addUserForm").reset();
            });
        });
    });
</script>
@endsection
