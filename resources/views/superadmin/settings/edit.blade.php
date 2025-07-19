@extends('layouts.app')

@section('title', 'Edit Setting')

@section('content_header')
    <h1>Edit Setting</h1>
@stop

@section('content')
    <form action="{{ route('superadmin.settings.update', $setting) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="key">Key</label>
                    <input type="text" name="key" id="key" class="form-control" value="{{ $setting->key }}" disabled>
                </div>
                <div class="form-group">
                    <label for="label">Label</label>
                    <input type="text" name="label" id="label" class="form-control" required value="{{ old('label', $setting->label) }}">
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control" required onchange="toggleValueInput()">
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ old('type', $setting->type) == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" id="valueInput">
                    <label for="value">Value</label>
                    @if($setting->type === 'image' && $setting->value)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $setting->value) }}" alt="Current Image" style="max-height:40px;">
                        </div>
                        <input type="file" name="value" id="value" class="form-control">
                    @elseif($setting->type === 'textarea')
                        <textarea name="value" id="value" class="form-control">{{ old('value', $setting->value) }}</textarea>
                    @else
                        <input type="text" name="value" id="value" class="form-control" value="{{ old('value', $setting->value) }}">
                    @endif
                </div>
                <div class="form-group">
                    <label for="group">Group</label>
                    <select name="group" id="group" class="form-control" required>
                        @foreach($groups as $group)
                            <option value="{{ $group }}" {{ old('group', $setting->group) == $group ? 'selected' : '' }}>{{ ucfirst($group) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control">{{ old('description', $setting->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="options">Options (JSON for select type)</label>
                    <textarea name="options" id="options" class="form-control">{{ old('options', is_array($setting->options) ? json_encode($setting->options) : $setting->options) }}</textarea>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" name="is_public" id="is_public" class="form-check-input" value="1" {{ old('is_public', $setting->is_public) ? 'checked' : '' }}>
                    <label for="is_public" class="form-check-label">Is Public</label>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('superadmin.settings.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
    <script>
        function toggleValueInput() {
            var type = document.getElementById('type').value;
            var valueInput = document.getElementById('valueInput');
            if(type === 'image') {
                valueInput.innerHTML = `<label for="value">Value</label>
                    @if($setting->type === 'image' && $setting->value)
                        <div class=\"mb-2\"><img src=\"{{ asset('storage/' . $setting->value) }}\" alt=\"Current Image\" style=\"max-height:40px;\"></div>
                    @endif
                    <input type=\"file\" name=\"value\" id=\"value\" class=\"form-control\">`;
            } else if(type === 'textarea') {
                valueInput.innerHTML = '<label for="value">Value</label><textarea name="value" id="value" class="form-control">{{ old('value', $setting->value) }}</textarea>';
            } else {
                valueInput.innerHTML = '<label for="value">Value</label><input type="text" name="value" id="value" class="form-control" value="{{ old('value', $setting->value) }}">';
            }
        }
        document.addEventListener('DOMContentLoaded', toggleValueInput);
    </script>
@stop 