<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Profile Update</title>
    <style>
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

<main class="max-w-lg my-4 mx-auto space-y-4">
    <div class="shadow bg-white p-4 rounded-md">
        <p class="text-lg text-center flex justify-center border-b-2 text-gray-500">Profile Information</p>
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center">
                {{ session('status') }}
            </div>
        @endif
        <form method="post" action="{{ route('profile.update') }}"
              enctype="multipart/form-data" class="flex-col justify-center mt-3">
            @csrf
            @method('patch')
            <div class="profile-pic-container flex justify-center"
                 onclick="document.getElementById('profilePicInput').click()">
                <img id="profilePic"
                     src="{{ Auth::user()->profile_pic ? asset('storage/profile_pics/' . Auth::user()->profile_pic) : asset('storage/' . 'profile_pics/profile.png')}}"
                     alt="Profile Picture">
                <input type="file" name="profile_pic" id="profilePicInput" accept="image/*" onchange="previewProfilePic(event)">
            </div>
            <div class="grid px-4 py-2">
                <label class="text-gray-600">Full Name :</label>
                <input type="text" class="rounded-sm" name="name" value="{{$user['name']}}" placeholder="Enter full name">
            </div>
            <div class="grid px-4 py-2">
                <label class="text-gray-600">Email :</label>
                <input type="email" class="rounded-sm" name="email" value="{{$user->email}}" placeholder="Enter email">
            </div>
            <button type="submit" class="px-6 py-2 my-4 ml-4 bg-blue-400 text-white rounded-md">Save</button>
        </form>
    </div>

    <div class="shadow bg-white p-4 rounded-md">
        <h3 class="my-2 text-lg text-center border-b-2 text-gray-500">Update Password</h3>
        <form method="post" action=" {{ route('password.update') }}" class="flex-col justify-center">
            @csrf
            @method('put')
            <div class="grid px-4 py-2">
                <label class="text-gray-600">Current Password :</label>
                <input type="password" name="current_password" class="rounded-sm" placeholder="Enter current password">
            </div>
            <div class="grid px-4 py-2">
                <label class="text-gray-600">New Password :</label>
                <input type="password" name="password" class="rounded-sm" placeholder="Enter new password">
            </div>
            <div class="grid px-4 py-2">
                <label class="text-gray-600">Confirm Password :</label>
                <input type="password" name="password_confirmation" class="rounded-sm" placeholder="Confirm new password">
            </div>
            <button type="submit" class="px-6 py-2 my-4 ml-4 bg-blue-400 text-white rounded-md">Save</button>
        </form>
        <div class="pt-4 flex justify-end">
            <button class="px-6 py-2 my-4 ml-4 bg-red-400 text-white rounded-md " onclick="openPopup()">Delete Account</button>
        </div>
    </div>
    <div class="popup-overlay" id="popup">
        <div class="p-4 max-w-lg bg-white rounded-md shadow-md">
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')
                <p class="text-red-400 text-lg">Are you sure you want to delete your account?</p>
                <p class="mt-1 text-sm text-gray-600">Once your account is deleted, all of its resources and data will be permanently deleted.
                    Please enter your password to confirm you would like to permanently delete your account.</p>
                <div class="mt-6 w-full">
                    <label for="password" class="text-gray-600">Password :</label>
                    <input id="password" name="password" type="password" class="w-full rounded-md" placeholder="{{ __('Password') }}"/>
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="error-mgs"/>
                </div>

                <div class="py-4">
                    <button class="px-4 py-2 text-white bg-red-400 rounded-md" onclick="confirmDelete()">Confirm</button>
                    <button class="px-4 py-2 mx-2 text-white bg-gray-600 rounded-md" onclick="closePopup()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</main>
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
