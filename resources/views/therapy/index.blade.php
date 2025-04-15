@extends('layouts.master2')
@section('content')
    <div class="main-content">
        @include('search_form')
        <div class="patient-contaier">

            <div class="actions">
                <div class="title-container">
                    <h1 class="page-title">{{ __('site.therapy list') }}</h1>
                </div>

                <div class="button-container2">
                    @if (!$therapies->isEmpty())
                    <a class="add-patient-btn" href="{{ route('playlist') }}">{{ __('site.My Playlist') }}</a>
                    @endif
                    @role('Admin')
                    <a href="{{ route('admin_therapy_create') }}" class="add-primery-btn">{{ __('site.Add Therapy') }}</a>
                    @endrole
                    @role('Doctor')
                    <a href="{{ route('doctors.booking.index') }}" class="add-primery-btn">{{ __('site.Patients Booking') }}</a>
                    @endrole
                    @role('Patient')
                    <a href="{{ route('patients.booking.index') }}" class="add-primery-btn">{{ __('site.My Bookings') }}</a>
                    @endrole
                </div>
            </div>

            <div class="table-container">
                <table id="patientTable" class="patient-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('site.Name') }}</th>
                            <th>{{ __('site.Doctor Name') }}</th>
                            <th>{{ __('site.Created') }}</th>
                            <th>{{ __('site.Updated') }}</th>
                            @role('Admin|Doctor')
                                <th>{{ __('site.Actions') }}</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody id="patientTbody">
                        @foreach ($therapies as $therapy)
                            <tr>
                                <td>{{ $therapy->id }}</td>
                                <td>{{ $therapy->name }}</td>
                                <td>{{ $therapy->user->name }}</td>
                                <td class="custom-date">{{ \Carbon\Carbon::parse($therapy->created_at)->format('d-m-Y') }}
                                <td class="custom-date">{{ \Carbon\Carbon::parse($therapy->updated_at)->format('d-m-Y') }}
                                    @role('Admin|Doctor')
                                    <td>
                                        <a href="{{ route('therapy.edit', $therapy) }}" class="btn edit-btn">{{ __('site.Edit') }}</a>

                                        <form class="btn delete-btn" action="{{ route('therapy.destroy', $therapy) }}" method="post" class="m-0"
                                            id="deleteForm-{{ $therapy->id }}">
                                            @csrf
                                            @method('delete')
                                            <a
                                                onclick="event.preventDefault(); document.getElementById('deleteForm-{{ $therapy->id }}').submit();">
                                                <strong>X</strong>
                                            </a>
                                        </form>
                                    </td>
                                @endrole
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination1">
                    {{$therapies->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function showPreview(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imgElement = document.getElementById('image-preview');
                imgElement.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
