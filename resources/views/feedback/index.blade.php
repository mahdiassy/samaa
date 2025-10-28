@extends('layouts.master2')
@section('content')
    <!-- Feedback Management Content with Consistent Layout -->
    <div class="feedback-management-content">
        @include('search_form')
        <div class="patient-contaier">

            <div class="actions" style="padding-bottom: 20px">
                <div class="title-container">
                    <h1 class="page-title">{{ __('site.Feedback list') }}</h1>
                </div>
                <div class="button-container">
                    <a href="#" class="filter-link">
                        {{ __('site.Filter') }}
                        <svg width="19" height="22" viewBox="0 0 19 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.3298 1L3.3998 8.9M2.7998 1H15.9998C17.0998 1 17.9998 1.9 17.9998 3V5.2C17.9998 6 17.4998 7 16.9998 7.5L12.6998 11.3C12.0998 11.8 11.6998 12.8 11.6998 13.6V17.9C11.6998 18.5 11.2998 19.3 10.7998 19.6L9.39981 20.5C8.09981 21.3 6.2998 20.4 6.2998 18.8V13.5C6.2998 12.8 5.8998 11.9 5.4998 11.4L1.6998 7.4C1.1998 6.9 0.799805 6 0.799805 5.4V3.1C0.799805 1.9 1.6998 1 2.7998 1Z"
                                stroke="#1A655E" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="table-container">
                <table id="patientTable" class="patient-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('site.User Name') }}</th>
                            <th>{{ __('site.Email') }}</th>
                            <th>{{ __('site.Subject') }}</th>
                            <th>{{ __('site.Date') }}</th>
                            <th>{{ __('site.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody id="patientTbody">
                        @foreach($feedbacks as $feedback)
                            <tr>
                                <td>{{ $feedback->id }}</td>
                                <td>{{ $feedback->full_name }}</td>
                                <td>{{ $feedback->email }}</td>
                                <td>{{ __($feedback->subject) }}</td>
                                <td class="custom-date">{{ \Carbon\Carbon::parse($feedback->date)->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('feedback.show', $feedback) }}" class="btn view-btn">{{ __('site.View') }}</a>
                                    @role('Admin')
                                        <form class="delete-form" action="{{ route('feedback.destroy', $feedback) }}" method="post" class="m-0"
                                            id="deleteForm-{{ $feedback->id }}">
                                            @csrf
                                            @method('delete')
                                            <a class="btn delete-btn"
                                                onclick="event.preventDefault(); document.getElementById('deleteForm-{{ $feedback->id }}').submit();">
                                                <strong>X</strong>
                                            </a>
                                        </form>
                                    @endrole
                                </td>
                            </tr>
                        @endforeach
                        <!-- More rows as needed -->
                    </tbody>
                </table>

                <div class="pagination1">
                    {{ $feedbacks->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
@endsection
