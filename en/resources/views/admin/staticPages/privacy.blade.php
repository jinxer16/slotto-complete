@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.staticPage.title') }} / {{ trans('cruds.staticPage.privacy.title') }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route("admin.static-pages.update", $page) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="heading">{{ trans('cruds.staticPage.privacy.fields.heading') }}</label>
                <input class="form-control {{ $errors->has('heading') ? 'is-invalid' : '' }}" type="text" name="heading" id="heading" value="{{ old('heading', @$data->heading) }}">
                @if($errors->has('heading'))
                    <div class="invalid-feedback">
                        {{ $errors->first('heading') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.staticPage.privacy.fields.heading_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="privacy_description">{{ trans('cruds.staticPage.privacy.fields.privacy_description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('privacy_description') ? 'is-invalid' : '' }}" name="privacy_description" id="privacy_description">{!! old('privacy_description', @$data->privacy_description) !!}</textarea>
                @if($errors->has('privacy_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('privacy_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.staticPage.privacy.fields.privacy_description_helper') }}</span>
            </div>

            @php
            /**
                     * @var $data from controller
                    */
                    $seo_title = @$data->seo_title;
                    $seo_keyword = @$data->seo_keyword;
                    $seo_description = @$data->seo_description;
                    @endphp
                    @include('partials.seoFields', compact('errors', 'seo_title', 'seo_keyword', 'seo_description'))

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        function SimpleUploadAdapter(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                return {
                    upload: function() {
                        return loader.file
                            
                    }
                };
            }
        }

        var allEditors = document.querySelectorAll('.ckeditor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(
                allEditors[i], {
                    extraPlugins: [SimpleUploadAdapter]
                }
            );
        }
    });
</script>
@endsection