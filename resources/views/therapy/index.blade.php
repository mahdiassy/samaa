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
                    <h1 class="page-title">therapy list</h1>
                </div>
            </div>

            <div class="user-form-container">
                @role('Admin|Doctor')
                    <div class="users-list-filter">
                        <form action="{{ route('therapy.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-section">
                                <div class="image-upload-wrapper">
                                    <input type="file" id="image-upload" name="image" accept="image/*" onchange="showPreview(event)" style="display:none;">
                                    <label for="image-upload" class="upload-label">
                                        <div class="image-placeholder">
                                            <img id="image-preview" src="https://via.placeholder.com/150" alt="Placeholder" class="placeholder-img">
                                            <div class="edit-icon">
                                                <img src="https://img.icons8.com/ios-filled/30/000000/edit.png" alt="Edit" />
                                            </div>
                                        </div>
                                    </label>
                                    <p class="image-upload-instruction">Set the Therapy thumbnail image. Only *.png, *.jpg, and *.jpeg image files are accepted</p>
                                </div>

                                <!-- Flex container for File Name and Upload File -->
                                <div class="input-row">
                                    <div class="input-group">
                                        <label for="file-name">File Name</label>
                                        <input type="text" id="file-name" class="form-input" name="name" placeholder="File Name" required>
                                    </div>
                                    <div class="input-group">
                                        <label for="file-upload">Upload File</label>
                                        <input type="file" class="form-input" name="file" id="file-upload" required>
                                    </div>
                                </div>

                                <!-- New input row for Select Patient and additional input -->
                                <div class="input-row">
                                    <div class="input-group">
                                        <label>Select Patient</label>
                                        <select class="form-input" name="patient_id">
                                            @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}">{{ $patient->first_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="button-group">
                                    <button type="submit" class="custom-button">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endrole

                @if (!$therapies->isEmpty())
                    <div class="button-group-left">
                        <a class="custom-button" href="{{ route('playlist') }}">My Playlist</a>
                    </div>
                @endif
            </div>


            <div class="table-container">
                <table id="patientTable" class="patient-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Doctor Name</th>
                            <th>Created</th>
                            <th>Updated</th>
                            @role('Admin|Doctor')
                                <th>Actions</th>
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
                                <td>
                                    @role('Admin|Doctor')
                                        <a href="{{ route('therapy.edit', $therapy) }}" class="btn edit-btn">Edit</a>

                                        <form action="{{ route('therapy.destroy', $therapy) }}" method="post" class="m-0"
                                            id="deleteForm-{{ $therapy->id }}">
                                            @csrf
                                            @method('delete')
                                            <a class="btn delete-btn"
                                                onclick="event.preventDefault(); document.getElementById('deleteForm-{{ $therapy->id }}').submit();">
                                                <strong>X</strong>
                                            </a>
                                        </form>
                                    @endrole
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
