@extends('layouts.master')
@section('content')
    <section class="users-view">

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
                                        <td>{{ $therapy->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Doctor Name: </td>
                                        <td class="users-view-latest-activity">
                                            {{ $therapy->user->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>The File: </td>
                                        <td>
                                            <audio controls>
                                                <source src="
                                                    @if (auth()->user()->hasRole('Admin'))
                                                        {{ Storage::url(decrypt($therapy->file)) }}
                                                    @elseif (auth()->user()->hasRole('Patient'))
                                                        @if ($therapy->patients()->where('patient_id', App\Models\Patient::where('user_id', Auth::id())->first()->id)->first())
                                                            {{ Storage::url(decrypt($therapy->file)) }}
                                                        @else
                                                            {{ Storage::url($therapy->file) }}
                                                        @endif
                                                    @elseif (auth()->user()->hasRole('Doctor'))
                                                        @if ($therapy->user_id == Auth::id())
                                                            {{ Storage::url(decrypt($therapy->file)) }}
                                                        @else
                                                        {{ Storage::url($therapy->file) }}
                                                        @endif
                                                    @endif
                                                        " type="audio/mpeg">
                                                      Your browser does not support the audio element.
                                            </audio>
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
            <a type="reset" href="{{ route('therapy.index') }}" class="btn btn-light">Back</a>
        </div>
    </section>
@endsection
