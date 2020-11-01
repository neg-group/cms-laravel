@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (auth()->user()->permission > 32)
                            {{-- is admin --}}
                            @include('partials.list-user')
                        @endif

                        @include('partials.user-profile')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
