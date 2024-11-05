@extends('layouts.master2')
@section('content')
    <div class="main-content">
        <div class="search-container">
            <input type="text" placeholder="Search...">
            <button>
                <svg width="19" height="20" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20.75 20.1895L15.086 14.5255C16.4471 12.8914 17.1259 10.7956 16.981 8.67389C16.8362 6.55219 15.879 4.56801 14.3085 3.1341C12.7379 1.7002 10.6751 0.92697 8.54899 0.975279C6.42291 1.02359 4.39729 1.88971 2.89353 3.39347C1.38977 4.89723 0.523649 6.92284 0.47534 9.04893C0.427031 11.175 1.20026 13.2379 2.63416 14.8084C4.06807 16.3789 6.05225 17.3361 8.17395 17.481C10.2957 17.6258 12.3915 16.9471 14.0255 15.586L19.6895 21.25L20.75 20.1895ZM2.00003 9.24996C2.00003 7.91494 2.39591 6.6099 3.13761 5.49987C3.87931 4.38983 4.93351 3.52467 6.16691 3.01378C7.40031 2.50289 8.75751 2.36921 10.0669 2.62966C11.3763 2.89011 12.579 3.53299 13.523 4.47699C14.467 5.421 15.1099 6.62373 15.3703 7.9331C15.6308 9.24248 15.4971 10.5997 14.9862 11.8331C14.4753 13.0665 13.6102 14.1207 12.5001 14.8624C11.3901 15.6041 10.085 16 8.75003 16C6.96042 15.998 5.24469 15.2862 3.97925 14.0207C2.71381 12.7553 2.00201 11.0396 2.00003 9.24996Z"
                        fill="#818181" />
                </svg>
            </button>
        </div>
        <div class="patient-contaier">

            <div class="actions">
                <div class="title-container">
                    <h1 class="page-title">patient list</h1>
                </div>
                <div class="button-container">
                    <a href="#" class="filter-link">
                        Filter
                        <svg width="19" height="22" viewBox="0 0 19 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.3298 1L3.3998 8.9M2.7998 1H15.9998C17.0998 1 17.9998 1.9 17.9998 3V5.2C17.9998 6 17.4998 7 16.9998 7.5L12.6998 11.3C12.0998 11.8 11.6998 12.8 11.6998 13.6V17.9C11.6998 18.5 11.2998 19.3 10.7998 19.6L9.39981 20.5C8.09981 21.3 6.2998 20.4 6.2998 18.8V13.5C6.2998 12.8 5.8998 11.9 5.4998 11.4L1.6998 7.4C1.1998 6.9 0.799805 6 0.799805 5.4V3.1C0.799805 1.9 1.6998 1 2.7998 1Z"
                                stroke="#1A655E" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                    <a href="{{ route('patient.create') }}" class="add-patient-btn">Add New Patient</a>
                </div>
            </div>

            <div class="table-container">
                <table id="patientTable" class="patient-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Phone</th>
                            <th>Country</th>
                            <th>Blood Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="patientTbody">
                        @foreach ($patients as $patient)
                            <tr>
                                <td>{{ $patient->id }}</td>
                                <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                <td>{{ $patient->phone }}</td>
                                <td>{{ $patient->country->name }}</td>
                                <td class="custom-date">{{ $patient->blood_type }}</td>
                                <td>
                                    <a href="{{ route('patient.edit', $patient) }}" class="btn edit-btn">Edit</a>
                                    <a href="{{ route('patient.show', $patient) }}" class="btn view-btn">View</a>

                                    <!--<form class="btn delete-btn" action="{{ route('patient.destroy', $patient) }}" method="post" class="m-0" id="deleteForm-{{ $patient->id }}">
                                        @csrf
                                        @method('delete')
                                        <a class="btn delete-btn" onclick="event.preventDefault(); document.getElementById('deleteForm-{{ $patient->id }}').submit();">
                                            <strong>X</strong>
                                        </a>
                                    </form>-->

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    <span id="paginationInfo">Showing 1 to 2 of 2 entries</span>

                    <ul class="page-list" id="pageList">
                        <li><a href="#" id="prevBtn" onclick="changePage(currentPage - 1)" disabled>
                                <svg width="8" height="13" viewBox="0 0 8 13" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.41 11.3869L2.83 6.79688L7.41 2.20687L6 0.796875L0 6.79688L6 12.7969L7.41 11.3869Z"
                                        fill="#2E4049" />
                                </svg>
                            </a>
                        </li>
                        <li><a href="#" onclick="changePage(1)">1</a></li>
                        <li><a href="#" onclick="changePage(2)">2</a></li>
                        <li><a href="#" onclick="changePage(3)">3</a></li>
                        <li><a href="#">...</a></li>
                        <li><a href="#" onclick="changePage(99)">99</a></li>
                        <li>
                            <a href="#" id="nextBtn" onclick="changePage(currentPage + 1)">
                                <svg width="8" height="13" viewBox="0 0 8 13" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.589844 11.3869L5.16984 6.79688L0.589844 2.20687L1.99984 0.796875L7.99984 6.79688L1.99984 12.7969L0.589844 11.3869Z"
                                        fill="#2E4049" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
