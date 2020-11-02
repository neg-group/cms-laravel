@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if ($status)
                            <div class="alert alert-info" role="alert">
                                {{ $status }}
                            </div>
                        @endif

                        @include('partials.profile')

                        <br>
                        <hr><br>

                        @if (auth()->user()->permission > 32)
                            {{-- is admin --}}
                            @include('partials.users')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
