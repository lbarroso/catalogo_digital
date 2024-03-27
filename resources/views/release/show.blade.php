@extends('layouts.app')

@section('template_title')
    {{ $release->name ?? "{{ __('Show') Release" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Release</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('releases.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Artcve:</strong>
                            {{ $release->artcve }}
                        </div>
                        <div class="form-group">
                            <strong>Almcnt:</strong>
                            {{ $release->almcnt }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
