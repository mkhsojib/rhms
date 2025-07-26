@extends('adminlte::page')

@section('title', 'Edit Question')

@section('content_header')
    <h1>Edit Question</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Question</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.questions.update', $question) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="question_text">Question Text</label>
                    <textarea name="question_text" id="question_text" class="form-control @error('question_text') is-invalid @enderror" rows="3" required>{{ old('question_text', $question->question_text) }}</textarea>
                    @error('question_text')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="input_type">Input Type</label>
                    <select name="input_type" id="input_type" class="form-control @error('input_type') is-invalid @enderror" required>
                        <option value="">Select Input Type</option>
                        <option value="text" {{ old('input_type', $question->input_type) === 'text' ? 'selected' : '' }}>Text</option>
                        <option value="radio" {{ old('input_type', $question->input_type) === 'radio' ? 'selected' : '' }}>Radio Button</option>
                        <option value="checkbox" {{ old('input_type', $question->input_type) === 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                    </select>
                    @error('input_type')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" id="options_container" style="display: {{ in_array($question->input_type, ['radio', 'checkbox']) ? 'block' : 'none' }};">
                    <label>Options</label>
                    <div id="options_list">
                        @if($question->options && is_array($question->options))
                            @foreach($question->options as $index => $option)
                                <div class="input-group mb-2">
                                    <input type="text" name="options[]" class="form-control" value="{{ $option }}" placeholder="Option {{ $index + 1 }}">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-danger remove-option">Remove</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="input-group mb-2">
                                <input type="text" name="options[]" class="form-control" placeholder="Option 1">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-danger remove-option">Remove</button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-success btn-sm" id="add_option">
                        <i class="fas fa-plus"></i> Add Option
                    </button>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" required>
                        <option value="">Select Category</option>
                        <option value="ruqyah" {{ old('category', $question->category) === 'ruqyah' ? 'selected' : '' }}>Ruqyah Healing</option>
                        <option value="hijama" {{ old('category', $question->category) === 'hijama' ? 'selected' : '' }}>Hijama Cupping</option>
                    </select>
                    @error('category')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_active">Active</label>
                    <input type="hidden" name="is_active" value="0">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ $question->is_active ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Active</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="is_required">Required</label>
                    <input type="hidden" name="is_required" value="0">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_required" name="is_required" value="1" {{ $question->is_required ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_required">Required</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Question
                    </button>
                    <a href="{{ route('superadmin.questions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Show/hide options based on input type
    $('#input_type').change(function() {
        var inputType = $(this).val();
        if (inputType === 'radio' || inputType === 'checkbox') {
            $('#options_container').show();
        } else {
            $('#options_container').hide();
        }
    });

    // Add option
    $('#add_option').click(function() {
        var optionCount = $('#options_list .input-group').length + 1;
        var newOption = `
            <div class="input-group mb-2">
                <input type="text" name="options[]" class="form-control" placeholder="Option ${optionCount}">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-option">Remove</button>
                </div>
            </div>
        `;
        $('#options_list').append(newOption);
    });

    // Remove option
    $(document).on('click', '.remove-option', function() {
        $(this).closest('.input-group').remove();
    });
});
</script>
@stop 