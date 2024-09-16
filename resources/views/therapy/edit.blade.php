@extends('layouts.master')
@section('content')
    <section class="users-view">
        <form action="{{ route('therapy.update', $therapy) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- users view card data start -->
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>File name:</td>
                                            <td>
                                                <input class="form-control" name="name" type="text"
                                                    value="{{ $therapy->name }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Patients:</td>
                                            <td>
                                                <div class="form-group">
                                                    <label class="pt-2">Favourite Movies</label>
                                                    <select class="form-control" id="users-movies-select2" name="patient_id">
                                                        @foreach ($patients as $patient)
                                                            <option value="{{ $patient->id }}"
                                                                @if (in_array($patient->id, $therapy->patients->pluck('id')->toArray())) selected @endif>
                                                                {{ $patient->first_name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label> The File:
                                                </label>
                                                <div class="row">
                                                    <div class="col d-flex align-items-center">
                                                        <label class="mr-3 mb-0 users-list-status" for="audioFile">Edit
                                                            Audio (optional):</label>
                                                        <input type="file" class="form-control" id="audioFile"
                                                            name="file" accept="audio/*">
                                                    </div>
                                                    <div class="col d-flex align-items-center">
                                                        <label for="audioFile" class="mr-3 mb-0">Old Audio:</label>
                                                        <audio controls>
                                                            <source src="{{ Storage::url(decrypt($therapy->file)) }}"
                                                                type="audio/mpeg">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save
                    changes</button>
                <a type="reset" href="{{ route('therapy.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </section>
@endsection
