<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Profile Update</title>
    <style>
        .nav-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-pic-container {
            text-align: center;
            position: relative;
            cursor: pointer;
        }

        .profile-pic-container img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #1b2a4e;
        }

        .profile-pic-container input {
            display: none;
        }
    </style>
</head>
<body>
@include('custom-layouts.navbar')

<div class="nav-container">
    <h3 class="mb-3">Profile Information</h3>
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')
        <div class="profile-pic-container" onclick="document.getElementById('profilePicInput').click()">
            <img id="profilePic"
                 src="https://cdn2.iconfinder.com/data/icons/people-flat-design/64/Face-Profile-User-Man-Boy-Person-Avatar-512.png"
                 alt="Profile Picture">
            <input type="file" id="profilePicInput" accept="image/*" onchange="previewProfilePic(event)">
        </div>
        <div class="mb-3 mt-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" placeholder="Enter full name">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" placeholder="Enter email">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<div class="nav-container mt-4">
    <h3 class="mb-3">Update Password</h3>
    <form method="post" action=" {{ route('password.update') }}">
        @csrf
        @method('put')
        <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" class="form-control" placeholder="Enter current password">
        </div>
        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" class="form-control" placeholder="Enter new password">
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" placeholder="Confirm new password">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <div class="pt-4">
        <button class="btn btn-danger" onclick="openPopup()">Delete Account</button>
    </div>
</div>
<div class="popup-overlay" id="popup">
    <div class="popup-box">
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h4 class="text-danger font-bold">
                {{ __('Are you sure you want to delete your account?') }}
            </h4>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Password</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    placeholder="{{ __('Password') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="error-mgs"/>
            </div>

            <div class="popup-buttons">
                <button class="btn  btn-danger" onclick="confirmDelete()">Confirm</button>
                <button class="cancel" onclick="closePopup()">Cancel</button>
            </div>
        </form>
    </div>
</div>
@include('custom-layouts.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function previewProfilePic(event) {
        const reader = new FileReader();
        reader.onload = function () {
            document.getElementById('profilePic').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    //end profile js
    function openPopup() {
        document.getElementById("popup").style.display = "flex";
    }

    function closePopup() {
        document.getElementById("popup").style.display = "none";
    }

    function confirmDelete() {
        alert("Your account has been deleted.");
        closePopup();
    }

    // Close popup when clicking outside the box
    window.onclick = function (event) {
        let popup = document.getElementById("popup");
        if (event.target === popup) {
            closePopup();
        }
    }
</script>
</body>
</html>
