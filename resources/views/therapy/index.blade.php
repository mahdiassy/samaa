@extends('layouts.master')
@section('content')
    <!-- users list start -->
    <section class="users-list-wrapper">
        @if(auth()->user()->can(App\Enums\Permissions::THERAPY_CREATE))
        <div class="users-list-filter px-1">
            <form action="{{ route('therapy.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row border border-light rounded py-2 mb-2">
                    <div class="col-12 col-sm-6 col-lg-6">
                        <label for="users-list-verified">File Name</label>
                        <input type="text" class="form-control" name="name" placeholder="File Name" required
                            data-validation-required-message="This file name field is required">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-6">
                        <label for="users-list-status">Upload File</label>
                        <input type="file" class="form-control" name="file" id="file-upload" required
                            data-validation-required-message="This file field is required">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label class="pt-2">Select Patient</label>
                            <select class="form-control" id="users-movies-select2" name="patient_id">
                                @foreach ($patients as $patient)
                                  <option value="{{$patient->id}}">{{$patient->first_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Button placed under all three inputs -->
                    <div class="col-12 text-right mt-2">
                        <button class="btn btn-primary glow">Create</button>
                    </div>
                </div>

            </form>
        </div>
        @endif
        <div class="users-list-table">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <!-- datatable start -->
                        <div class="table-responsive">
                            <table id="users-list-datatable" class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Doctor Name</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                        <th>edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($therapies as $therapy)
                                        <tr>
                                            <td>-</td>
                                            <td>{{ $therapy->id }}</td>
                                            <td>
                                                <span class="text-truncate"><a
                                                    href="{{ route('therapy.show', $therapy) }}">{{ $therapy->name }}</a></span>
                                            </td>
                                            <td>{{ $therapy->user->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($therapy->created_at)->format('d-m-Y') }}
                                            <td>{{ \Carbon\Carbon::parse($therapy->updated_at)->format('d-m-Y') }}
                                            </td>
                                            <td><a href="{{ route('therapy.edit', $therapy) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24" class="main-grid-item-icon"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2">
                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                                    </svg>
                                                </a>
                                            </td>
                                            <td>
                                                <form action="{{ route('therapy.destroy', $therapy) }}" method="post"
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
