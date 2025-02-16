{{--<html>--}}
{{--<head>--}}
{{--    <title>Profile Edit</title>--}}
{{--    @include('custom-layouts.headTagContent')--}}
{{--</head>--}}
{{--</html>--}}
{{--<x-app-layout>--}}

{{--@include('custom-layouts.navbar')--}}
{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">--}}
{{--            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                <div class="max-w-xl">--}}
{{--                    @include('profile.partials.update-profile-information-form')--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                <div class="max-w-xl">--}}
{{--                    @include('profile.partials.update-password-form')--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                <div class="max-w-xl">--}}
{{--                    @include('profile.partials.delete-user-form')--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</x-app-layout>--}}

    <!DOCTYPE html>
<html lang="en">
<head>
@include('custom-layouts.headTagContent')
    <title>Profile Update</title>

    <style>
        .nav-container { max-width: 600px; margin: 50px auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .profile-pic-container { text-align: center; position: relative; cursor: pointer; }
        .profile-pic-container img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid #1b2a4e; }
        .profile-pic-container input { display: none; }
    </style>
</head>
<body>
@include('custom-layouts.navbar')

<div class="nav-container">
    <h3 class="mb-3">Profile Information</h3>
    <form>
        <div class="profile-pic-container" onclick="document.getElementById('profilePicInput').click()">
            <img id="profilePic" src="https://cdn2.iconfinder.com/data/icons/people-flat-design/64/Face-Profile-User-Man-Boy-Person-Avatar-512.png" alt="Profile Picture">
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
    <form>
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
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function previewProfilePic(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('profilePic').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
</body>
</html>
