<x-admin-layout>
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
    <div class="container max-w-md my-4 mx-auto space-y-4">
        <div class="shadow bg-white p-4 rounded-md">
            <p class="text-lg text-center flex justify-center border-b-2 text-gray-500">Profile Information</p>
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center">
                    {{ session('status') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-green-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center">
                    {{ $errors->first()}}
                </div>

            @endif
            <form method="post" action="{{ route('admin.profile.update') }}"
                  enctype="multipart/form-data" class="flex-col justify-center mt-3">
                @csrf
                @method('patch')
                <div class="profile-pic-container flex justify-center"
                     onclick="document.getElementById('profilePicInput').click()">
                    <img id="profilePic"
                         {{--                     src="{{ Auth::user()->profile_pic ? asset('storage/profile_pics/' . Auth::user()->profile_pic) : asset('storage/' . 'profile_pics/profile.png')}}"--}}
                         alt="Profile Picture">
                    <input type="file" name="profile_pic" id="profilePicInput" accept="image/*"
                           onchange="previewProfilePic(event)">
                </div>
                <div class="grid px-4 py-2">
                    <label class="text-gray-600">Full Name :</label>
                    <input type="text" class="rounded-sm" name="name" value="{{$user['name']}}"
                           placeholder="Enter full name">
                </div>
                <div class="grid px-4 py-2">
                    <label class="text-gray-600">Email :</label>
                    <input type="email" class="rounded-sm" name="email" value="{{$user->email}}"
                           placeholder="Enter email">
                </div>
                <button type="submit" class="px-6 py-2 my-4 ml-4 bg-blue-400 text-white rounded-md">Save</button>
            </form>
        </div>

        <div class="shadow bg-white p-4 rounded-md">
            <h3 class="my-2 text-lg text-center border-b-2 text-gray-500">Update Password</h3>
            <form method="post" action=" {{ route('admin.password.update') }}" class="flex-col justify-center">
                @csrf
                @method('put')
                <div class="grid px-4 py-2">
                    <label class="text-gray-600">Current Password :</label>
                    <input type="password" name="current_password" class="rounded-sm"
                           placeholder="Enter current password">
                </div>
                <div class="grid px-4 py-2">
                    <label class="text-gray-600">New Password :</label>
                    <input type="password" name="password" class="rounded-sm" placeholder="Enter new password">
                </div>
                <div class="grid px-4 py-2">
                    <label class="text-gray-600">Confirm Password :</label>
                    <input type="password" name="password_confirmation" class="rounded-sm"
                           placeholder="Confirm new password">
                </div>
                <button type="submit" class="px-6 py-2 my-4 ml-4 bg-blue-400 text-white rounded-md">Save</button>
            </form>
        </div>

    </div>
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
</x-admin-layout>


