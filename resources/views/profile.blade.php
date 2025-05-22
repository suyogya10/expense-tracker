@extends('layouts.admin')
<style>
    .loader-circle {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        border: 3px solid white;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
        transform: translate(-50%, -50%);
    }

    @keyframes spin {
        to {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    .btn.animating {
        width: 50px !important;
        height: 50px !important;
        border-radius: 50% !important;
        padding: 0 !important;
        transition: all 0.4s ease-in-out;
        text-indent: -9999px;
        overflow: hidden;
    }
</style>

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Profile') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        <div class="col-lg-4 order-lg-2">

            <div class="card shadow mb-4">
                <div class="card-profile-image mt-4">
                    <figure class="rounded-circle avatar avatar font-weight-bold"
                        style="font-size: 60px; height: 180px; width: 180px;" data-initial="{{ Auth::user()->name[0] }}">
                    </figure>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h5 class="font-weight-bold">{{ Auth::user()->fullName }}</h5>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-lg-8 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">My Account</h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('profile.update') }}" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="_method" value="PUT">

                        <h6 class="heading-small text-muted mb-4">User information</h6>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Name<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name"
                                            placeholder="Name" value="{{ old('name', Auth::user()->name) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="last_name">Last name</label>
                                        <input type="text" id="last_name" class="form-control" name="last_name"
                                            placeholder="Last name" value="{{ old('last_name', Auth::user()->last_name) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Email address<span
                                                class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email"
                                            placeholder="example@example.com"
                                            value="{{ old('email', Auth::user()->email) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="current_password">Current password</label>
                                        <input type="password" id="current_password" class="form-control"
                                            name="current_password" placeholder="Current password">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">New password</label>
                                        <input type="password" id="new_password" class="form-control" name="new_password"
                                            placeholder="New password">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="confirm_password">Confirm password</label>
                                        <input type="password" id="confirm_password" class="form-control"
                                            name="password_confirmation" placeholder="Confirm password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button id="saveChangesBtn" type="submit"
                                        class="btn btn-primary position-relative overflow-hidden">
                                        <span class="btn-text">Save Changes</span>
                                        <div class="loader-circle d-none"></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form[action='{{ route('profile.update') }}']");
            const btn = document.getElementById("saveChangesBtn");
            const loader = btn.querySelector(".loader-circle");
            const btnText = btn.querySelector(".btn-text");

            form.addEventListener("submit", function() {
                btn.classList.add("animating");
                loader.classList.remove("d-none");
                btnText.classList.add("invisible");
            });

            @if ($errors->any())
                // Revert animation if there are any validation errors
                btn.classList.remove("animating");
                loader.classList.add("d-none");
                btnText.classList.remove("invisible");
            @endif
        });
    </script>

@endsection
