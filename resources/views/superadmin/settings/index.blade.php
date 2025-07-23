@extends('layouts.app')

@section('title', 'System Settings')

@section('content_header')
    <h1>System Settings</h1>
    <a href="{{ route('superadmin.settings.create') }}" class="btn btn-primary float-right">
        <i class="fas fa-plus"></i> Add New Setting
    </a>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <!-- Settings Group Navigation Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-cog fa-3x mb-3 text-primary"></i>
                    <h5>General Settings</h5>
                    <p class="text-muted">Site name, contact info, etc.</p>
                    <a href="{{ route('superadmin.settings.general') }}" class="btn btn-primary btn-block">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-paint-brush fa-3x mb-3 text-success"></i>
                    <h5>Appearance Settings</h5>
                    <p class="text-muted">Logo, colors, theme options</p>
                    <a href="{{ route('superadmin.settings.appearance') }}" class="btn btn-success btn-block">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-server fa-3x mb-3 text-warning"></i>
                    <h5>System Settings</h5>
                    <p class="text-muted">Maintenance, registration, etc.</p>
                    <a href="{{ route('superadmin.settings.system') }}" class="btn btn-warning btn-block">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-briefcase fa-3x mb-3 text-info"></i>
                    <h5>Business Settings</h5>
                    <p class="text-muted">Currency, business hours, fees</p>
                    <a href="{{ route('superadmin.settings.business') }}" class="btn btn-info btn-block">Manage</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Settings Group Navigation Cards -->
    @foreach($settings as $group => $groupSettings)
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h4 class="mb-0 text-capitalize">{{ $group }} Settings</h4>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Key</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupSettings as $setting)
                            <tr>
                                <td>{{ $setting->label }}</td>
                                <td><code>{{ $setting->key }}</code></td>
                                <td>{{ ucfirst($setting->type) }}</td>
                                <td>
                                    @if($setting->type === 'image' && $setting->value)
                                        <img src="{{ asset('storage/' . $setting->value) }}" alt="{{ $setting->label }}" style="max-height:40px;">
                                    @elseif($setting->type === 'boolean')
                                        <span class="badge badge-{{ $setting->value ? 'success' : 'secondary' }}">{{ $setting->value ? 'Yes' : 'No' }}</span>
                                    @else
                                        {{ Str::limit($setting->value, 40) }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('superadmin.settings.edit', $setting) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('superadmin.settings.destroy', $setting) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this setting?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@stop 