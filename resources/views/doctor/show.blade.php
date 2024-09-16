@extends('layouts.master')
@section('content')
    <section class="users-view">
        <!-- users view media object start -->
        <div class="row">
            <div class="col-12 col-sm-7">
                <div class="media mb-2">
                    <a class="mr-1" href="#">
                        <img src="{{ Storage::url($doctor->image) }}" alt="users view avatar"
                            class="users-avatar-shadow rounded-circle" height="64" width="64">
                    </a>
                    <div class="media-body pt-25">
                        <h4 class="media-heading"><span class="users-view-name">{{ $doctor->first_name }}
                                {{ $doctor->last_name }}</span>
                        </h4>
                        <span>ID:</span>
                        <span class="users-view-id">{{ $doctor->id }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
                <a href="{{ route('doctor.index') }}" class="btn btn-sm mr-25 border">Back</a>
                <a href="{{ route('doctor.edit', $doctor) }}"
                    class="btn btn-sm btn-primary">Edit</a>
            </div>
        </div>
        <!-- users view media object ends -->
        <!-- users view card data start -->
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Registered:</td>
                                        <td>{{ \Carbon\Carbon::parse($doctor->created_at)->format('d-m-Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Latest update: </td>
                                        <td class="users-view-latest-activity">
                                            {{ \Carbon\Carbon::parse($doctor->updated_at)->format('d-m-Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Doctor Role: </td>
                                        <td class="users-view-latest-activity">
                                            {{$doctor->user->roles->pluck('name')->implode(', ')}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Verified:</td>
                                        <td>
                                            @if ($doctor->user->email_verified_at != null)
                                                <span class="badge badge-success ">Active</span>
                                            @else
                                                <span class="badge badge-danger ">Unactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="table-responsive">
                                <table class="table mb-0">
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
                                            <td>Yes</td>
                                            <td>No</td>
                                            <td>No</td>
                                            <td>Yes</td>
                                        </tr>
                                        <tr>
                                            <td>Articles</td>
                                            <td>No</td>
                                            <td>Yes</td>
                                            <td>No</td>
                                            <td>Yes</td>
                                        </tr>
                                        <tr>
                                            <td>Staff</td>
                                            <td>Yes</td>
                                            <td>Yes</td>
                                            <td>No</td>
                                            <td>No</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- users view card data ends -->
        <!-- users view card details start -->
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div style="display: none"
                        class="row bg-primary bg-lighten-5 rounded mb-2 mx-25 text-center text-lg-left">
                        <div class="col-12 col-sm-4 p-2">
                            <h6 class="text-primary mb-0">Posts: <span class="font-large-1 align-middle">125</span></h6>
                        </div>
                        <div class="col-12 col-sm-4 p-2">
                            <h6 class="text-primary mb-0">Followers: <span class="font-large-1 align-middle">534</span></h6>
                        </div>
                        <div class="col-12 col-sm-4 p-2">
                            <h6 class="text-primary mb-0">Following: <span class="font-large-1 align-middle">256</span></h6>
                        </div>
                    </div>
                    <div class="col-12">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>First Name:</td>
                                    <td class="users-view-username">{{ $doctor->first_name }}</td>
                                </tr>
                                <tr>
                                    <td>Last Name:</td>
                                    <td class="users-view-name">
                                        {{ $doctor->last_name }}</td>
                                </tr>
                                <tr>
                                    <td>E-mail:</td>
                                    <td class="users-view-email">{{ $doctor->user->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <h5 class="mb-1"><i class="feather icon-link"></i> Social
                            Links</h5>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>Twitter:</td>
                                    <td><a target="_blank" href="{{ $doctor->twitter }}">{{ $doctor->twitter }}</a></td>
                                </tr>
                                <tr>
                                    <td>Facebook:</td>
                                    <td><a target="_blank" href="{{ $doctor->facebook }}">{{ $doctor->facebook }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Instagram:</td>
                                    <td><a target="_blank" href="{{ $doctor->instagram }}">{{ $doctor->instagram }}</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h5 class="mb-1"><i class="feather icon-info"></i> Personal
                            Info</h5>
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td>Birthday:</td>
                                    <td>{{ \Carbon\Carbon::parse($doctor->birthday)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td>{{ $doctor->address }}</td>
                                </tr>
                                <tr>
                                    <td>Contact:</td>
                                    <td>{{ $doctor->phone }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- users view card details ends -->

    </section>
@endsection
