@extends('layouts.master')
@section('content')
    <!-- users list start -->
    <section class="users-list-wrapper">
        <!--<div class="users-list-filter px-1">
                        <form>
                            <div class="row border border-light rounded py-2 mb-2">
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label for="users-list-verified">Verified</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="users-list-verified">
                                            <option value>Any</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label for="users-list-role">Role</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="users-list-role">
                                            <option value>Any</option>
                                            <option value="User">User</option>
                                            <option value="Staff">Staff</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <label for="users-list-status">Status</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="users-list-status">
                                            <option value>Any</option>
                                            <option value="Active">Active</option>
                                            <option value="Close">Close</option>
                                            <option value="Banned">Banned</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
                                    <button class="btn btn-block btn-primary glow">Show</button>
                                </div>
                            </div>
                        </form>
                    </div>-->
        <div class="users-list-table">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <!-- datatable start -->
                        <div class="table-responsive">
                            <table id="users-list-datatable" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First name</th>
                                        <th>Last Name</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Birthday</th>
                                        @role('Admin')
                                            <th>edit</th>
                                            <th>Delete</th>
                                        @endrole
                                        @role('Patient')
                                            <th>Book an appointment</th>
                                            <th></th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($doctors as $doctor)
                                        <tr>
                                            <td>{{ $doctor->id }}</td>
                                            <td>
                                                <div class="avatar avatar-md mr-1">
                                                    <img class="rounded-circle"
                                                        src="{{ Storage::url($doctor->image) }}"
                                                        alt="Generic placeholder image">
                                                </div>
                                                <span class="text-truncate"><a
                                                        href="{{ route('doctor.show', $doctor) }}">{{ $doctor->first_name }}</a></span>
                                            </td>
                                            <td>{{ $doctor->last_name }}</td>
                                            <td>{{ $doctor->phone }}</td>
                                            <td>{{ $doctor->address }}</td>
                                            <td>{{ \Carbon\Carbon::parse($doctor->birthday)->format('d-m-Y') }}
                                            </td>
                                            @role('Patient')
                                                <td>
                                                    <a href="{{ route('patients.calendar', $doctor) }}">
                                                        <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                                <td></td>
                                            @endrole
                                            @role('Admin')
                                            <td><a href="{{ route('doctor.edit', $doctor) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24" class="main-grid-item-icon"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2">
                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                                    </svg>
                                                </a>
                                            </td>
                                            <td>
                                                <form action="{{ route('doctor.destroy', $doctor) }}" method="post"
                                                    class="m-0">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" value="delete" class="dropdown-item"><svg
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            width="24" height="24" class="main-grid-item-icon"
                                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2">
                                                            <polyline points="3 6 5 6 21 6" />
                                                            <path
                                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                            <line x1="10" x2="10" y1="11"
                                                                y2="17" />
                                                            <line x1="14" x2="14" y1="11"
                                                                y2="17" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                            @endrole
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- datatable ends -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- users list ends -->
@endsection
