@extends('layouts.master')
@section('content')
    <section class="users-edit">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab"
                                href="#account" aria-controls="account" role="tab" aria-selected="true">
                                <span class="d-none d-sm-block">Account</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="information-tab" data-toggle="tab"
                                href="#information" aria-controls="information" role="tab" aria-selected="false">
                                <span class="d-none d-sm-block">Information</span>
                            </a>
                        </li>
                    </ul>
                    <form novalidate action="{{ route('patient.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="tab-content">
                            <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                <!-- users edit media object start -->
                                <div class="media mb-2">
                                    <a class="mr-2" href="#"
                                        onclick="document.getElementById('avatarInput').click();">
                                        <img src="{{ asset('assets/images/avatar1.png') }}" alt="users avatar"
                                            class="users-avatar-shadow rounded-circle" height="64" width="64"
                                            id="avatarPreview">
                                    </a>
                                    <input type="file" id="avatarInput" name="image" style="display:none;"
                                        onchange="previewImage(event)">

                                    <div class="media-body">
                                        <h4 class="media-heading">Avatar</h4>
                                        <div class="col-12 px-0 d-flex">
                                            <a href="#" class="btn btn-sm btn-primary mr-25"
                                                onclick="document.getElementById('avatarInput').click();">Change</a>
                                            <a href="#" class="btn btn-sm btn-secondary"
                                                onclick="resetImage();">Reset</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- users edit media object ends -->
                                <!-- users edit account form start -->

                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" name="first_name"
                                                    placeholder="First Name" required
                                                    data-validation-required-message="This first name field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>E-mail</label>
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="Email" required
                                                    data-validation-required-message="This email field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Password</label>
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="Password" required
                                                    data-validation-required-message="This password field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" name="last_name"
                                                    placeholder="Last Name" required
                                                    data-validation-required-message="This last name field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select class="form-control" name="role">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table mt-1">
                                                <thead>
                                                    <tr>
                                                        <th>Module Permission</th>
                                                        <th>Read</th>
                                                        <th>Write</th>
                                                        <th>Create</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Users</td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox"><input
                                                                    type="checkbox" id="users-checkbox1"
                                                                    class="custom-control-input" checked>
                                                                <label class="custom-control-label"
                                                                    for="users-checkbox1"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox"><input
                                                                    type="checkbox" id="users-checkbox2"
                                                                    class="custom-control-input"><label
                                                                    class="custom-control-label"
                                                                    for="users-checkbox2"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox"><input
                                                                    type="checkbox" id="users-checkbox3"
                                                                    class="custom-control-input"><label
                                                                    class="custom-control-label"
                                                                    for="users-checkbox3"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox"><input
                                                                    type="checkbox" id="users-checkbox4"
                                                                    class="custom-control-input" checked>
                                                                <label class="custom-control-label"
                                                                    for="users-checkbox4"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Articles</td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox"><input
                                                                    type="checkbox" id="users-checkbox5"
                                                                    class="custom-control-input"><label
                                                                    class="custom-control-label"
                                                                    for="users-checkbox5"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox"><input
                                                                    type="checkbox" id="users-checkbox6"
                                                                    class="custom-control-input" checked>
                                                                <label class="custom-control-label"
                                                                    for="users-checkbox6"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox"><input
                                                                    type="checkbox" id="users-checkbox7"
                                                                    class="custom-control-input"><label
                                                                    class="custom-control-label"
                                                                    for="users-checkbox7"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox"><input
                                                                    type="checkbox" id="users-checkbox8"
                                                                    class="custom-control-input" checked>
                                                                <label class="custom-control-label"
                                                                    for="users-checkbox8"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Staff</td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox"><input
                                                                    type="checkbox" id="users-checkbox9"
                                                                    class="custom-control-input" checked>
                                                                <label class="custom-control-label"
                                                                    for="users-checkbox9"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox"><input
                                                                    type="checkbox" id="users-checkbox10"
                                                                    class="custom-control-input" checked>
                                                                <label class="custom-control-label"
                                                                    for="users-checkbox10"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox"><input
                                                                    type="checkbox" id="users-checkbox11"
                                                                    class="custom-control-input"><label
                                                                    class="custom-control-label"
                                                                    for="users-checkbox11"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox"><input
                                                                    type="checkbox" id="users-checkbox12"
                                                                    class="custom-control-input"><label
                                                                    class="custom-control-label"
                                                                    for="users-checkbox12"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- users edit account form ends -->
                            </div>
                            <div class="tab-pane" id="information" aria-labelledby="information-tab" role="tabpanel">
                                <!-- users edit Info form start -->
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <h5 class="mb-1">Social Links</h5>
                                        <div class="form-group">
                                            <label>Twitter</label>
                                            <input class="form-control" name="twitter" type="text"
                                                value="https://www.twitter.com/">
                                        </div>
                                        <div class="form-group">
                                            <label>Facebook</label>
                                            <input class="form-control" name="facebook" type="text"
                                                value="https://www.facebook.com/">
                                        </div>
                                        <div class="form-group">
                                            <label>Instagram</label>
                                            <input class="form-control" name="instagram" type="text"
                                                value="https://www.instagram.com/">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 mt-1 mt-sm-0">
                                        <h5 class="mb-1">Personal Info</h5>
                                        <div class="form-group">
                                            <div class="controls position-relative">
                                                <label>Birth date</label>
                                                <input type="text" name="birthday"
                                                    class="form-control birthdate-picker" required
                                                    placeholder="Birth date"
                                                    data-validation-required-message="This birthdate field is required">
                                            </div>
                                        </div>
                                        <div style="display: none" class="form-group">
                                            <label>Country</label>
                                            <select class="form-control" id="accountSelect">
                                                <option>USA</option>
                                                <option>India</option>
                                                <option>Canada</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Phone</label>
                                                <input type="text" class="form-control" required
                                                    placeholder="Phone number" name="phone"
                                                    data-validation-required-message="This phone number field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Address</label>
                                                <input type="text" class="form-control" name="address"
                                                    placeholder="Address"
                                                    data-validation-required-message="This Address field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: none" class="col-12">
                                        <div class="form-group">
                                            <label>Favourite movies</label>
                                            <select class="form-control" id="users-movies-select2" multiple="multiple">
                                                <option value="The Dark Knight" selected>The Dark Knight
                                                </option>
                                                <option value="Harry Potter" selected>Harry Potter</option>
                                                <option value="Airplane!">Airplane!</option>
                                                <option value="Perl Harbour">Perl Harbour</option>
                                                <option value="Spider Man">Spider Man</option>
                                                <option value="Iron Man" selected>Iron Man</option>
                                                <option value="Avatar">Avatar</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- users edit Info form ends -->
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                            <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save
                                changes</button>
                            <a type="reset" href="{{ route('patient.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('avatarPreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function resetImage() {
        const preview = document.getElementById('avatarPreview');
        preview.src = '{{ asset('assets/images/avatar1.png') }}';
        document.getElementById('avatarInput').value = '';
    }
</script>
