@extends('layouts.app')

@section('title', 'Add New Setting')

@section('content_header')
    <h1>Add New Setting</h1>
@stop

@section('content')
    <form action="{{ route('superadmin.settings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="key">Key</label>
                    <input type="text" name="key" id="key" class="form-control" required value="{{ old('key') }}">
                </div>
                <div class="form-group">
                    <label for="label">Label</label>
                    <input type="text" name="label" id="label" class="form-control" required value="{{ old('label') }}">
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control" required onchange="toggleValueInput()">
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" id="valueInput">
                    <label for="value">Value</label>
                    <input type="text" name="value" id="value" class="form-control" value="{{ old('value') }}">
                </div>
                <div class="form-group">
                    <label for="group">Group</label>
                    <select name="group" id="group" class="form-control" required>
                        @foreach($groups as $group)
                            <option value="{{ $group }}" {{ old('group') == $group ? 'selected' : '' }}>{{ ucfirst($group) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="options">Options (JSON for select type)</label>
                    <textarea name="options" id="options" class="form-control">{{ old('options') }}</textarea>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" name="is_public" id="is_public" class="form-check-input" value="1" {{ old('is_public') ? 'checked' : '' }}>
                    <label for="is_public" class="form-check-label">Is Public</label>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('superadmin.settings.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
    <script>
        function toggleValueInput() {
            var type = document.getElementById('type').value;
            var valueInput = document.getElementById('valueInput');
            if(type === 'image') {
                valueInput.innerHTML = '<label for="value">Value</label><input type="file" name="value" id="value" class="form-control">';
            } else if(type === 'textarea') {
                valueInput.innerHTML = '<label for="value">Value</label><textarea name="value" id="value" class="form-control">{{ old('value') }}</textarea>';
            } else {
                valueInput.innerHTML = '<label for="value">Value</label><input type="text" name="value" id="value" class="form-control" value="{{ old('value') }}">';
            }
        }
        document.addEventListener('DOMContentLoaded', toggleValueInput);
    </script>
@stop 