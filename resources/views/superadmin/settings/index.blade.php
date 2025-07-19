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