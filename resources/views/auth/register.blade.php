@extends('layouts.base')
@section('content')
    <div class="empty-container" style="min-height: 80vh;"></div>

    <!-- Modal -->
    <div class="modal fade show d-block" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-modal-width">
            <div class="modal-content custom-modal-content text-center">
                <div class="modal-header border-0">
                    <h5 class="modal-title w-100" id="roleModalLabel">{{ __('site.Choose Registration Type') }}</h5>
                </div>
                <div class="modal-body">
                    <a href="{{ route('showRegisterPatient') }}"
                        class="btn btn-patient m-2">{{ __('site.Register as Patient') }}</a>
                    <a href="{{ route('showRegisterDoctor') }}"
                        class="btn btn-doctor m-2">{{ __('site.Register as Doctor') }}</a>
                </div>
            </div>
        </div>
    </div>
    <style>
        .custom-modal-width {
            max-width: 500px;
            margin: auto;
        }

        .custom-modal-content {
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .btn-patient {
            background-color: #0F4140 !important;
            color: white !important;
            border: none;
            border-radius: 9px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }

        .btn-doctor {
            background-color: #D67E0D !important;
            color: white !important;
            border: none;
            border-radius: 9px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }

        .btn-doctor:hover {
            background-color: #da9030 !important;
        }

        .btn-patient:hover {
            background-color: #053930 !important;
        }
    </style>
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var roleModal = new bootstrap.Modal(document.getElementById('roleModal'), {
            backdrop: 'static',
            keyboard: false
        });
        roleModal.show();
    });
</script>
