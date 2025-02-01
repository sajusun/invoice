<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{--    <!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>Profile Update</title>--}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">--}}
{{--    <style>--}}
{{--        body { font-family: Arial, sans-serif; }--}}
{{--        .navbar { background: #e9ebef; }--}}
{{--        .navbar a { color: white; }--}}
{{--        .container { max-width: 600px; margin: 50px auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }--}}
{{--        .profile-pic-container { text-align: center; position: relative; cursor: pointer; }--}}
{{--        .profile-pic-container img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid #1b2a4e; }--}}
{{--        .profile-pic-container input { display: none; }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<nav class="navbar navbar-expand-lg navbar-dark">--}}
{{--    <div class="container-fluid">--}}
{{--        <a class="navbar-brand" href="#">My Dashboard</a>--}}
{{--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">--}}
{{--            <span class="navbar-toggler-icon"></span>--}}
{{--        </button>--}}
{{--        <div class="collapse navbar-collapse" id="navbarNav">--}}
{{--            <ul class="navbar-nav ms-auto">--}}
{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">--}}
{{--                        User--}}
{{--                    </a>--}}
{{--                    <ul class="dropdown-menu dropdown-menu-end">--}}
{{--                        <li><a class="dropdown-item" href="#">Profile</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#">Settings</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#">Logout</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</nav>--}}

{{--<div class="container">--}}
{{--    <h3 class="mb-3">Profile Information</h3>--}}
{{--    <form>--}}
{{--        <div class="profile-pic-container" onclick="document.getElementById('profilePicInput').click()">--}}
{{--            <img id="profilePic" src="https://via.placeholder.com/120" alt="Profile Picture">--}}
{{--            <input type="file" id="profilePicInput" accept="image/*" onchange="previewProfilePic(event)">--}}
{{--        </div>--}}
{{--        <div class="mb-3 mt-3">--}}
{{--            <label class="form-label">Full Name</label>--}}
{{--            <input type="text" class="form-control" placeholder="Enter full name">--}}
{{--        </div>--}}
{{--        <div class="mb-3">--}}
{{--            <label class="form-label">Email</label>--}}
{{--            <input type="email" class="form-control" placeholder="Enter email">--}}
{{--        </div>--}}
{{--        <button type="submit" class="btn btn-primary">Save</button>--}}
{{--    </form>--}}
{{--</div>--}}

{{--<div class="container mt-4">--}}
{{--    <h3 class="mb-3">Update Password</h3>--}}
{{--    <form>--}}
{{--        <div class="mb-3">--}}
{{--            <label class="form-label">Current Password</label>--}}
{{--            <input type="password" class="form-control" placeholder="Enter current password">--}}
{{--        </div>--}}
{{--        <div class="mb-3">--}}
{{--            <label class="form-label">New Password</label>--}}
{{--            <input type="password" class="form-control" placeholder="Enter new password">--}}
{{--        </div>--}}
{{--        <div class="mb-3">--}}
{{--            <label class="form-label">Confirm Password</label>--}}
{{--            <input type="password" class="form-control" placeholder="Confirm new password">--}}
{{--        </div>--}}
{{--        <button type="submit" class="btn btn-primary">Save</button>--}}
{{--    </form>--}}
{{--</div>--}}

{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>--}}
{{--<script>--}}
{{--    function previewProfilePic(event) {--}}
{{--        const reader = new FileReader();--}}
{{--        reader.onload = function() {--}}
{{--            document.getElementById('profilePic').src = reader.result;--}}
{{--        }--}}
{{--        reader.readAsDataURL(event.target.files[0]);--}}
{{--    }--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}
