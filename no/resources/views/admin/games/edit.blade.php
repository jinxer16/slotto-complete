@extends('layouts.admin')
@section('styles')
<link rel="stylesheet" href="{{ asset('asset/admin/css/jquery.minicolors.css')}}">
@endsection
@section('content')
@php
    $all_game_category = \App\GameCategory::all();
    $all_similar_games = \App\Game::all();
    $all_slots = \App\Game::all();
    $all_casinos = \App\Casino::all();
    $all_faqQuestions = \App\FaqQuestion::all();
    $all_providers = \App\Software::all();
@endphp
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.game.title_singular') }}
    </div>
</div>
<form method="POST" action="{{ route("admin.games.update", [$game->id]) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="card">
        <div class="card-header">GAME</div>
        <div class="card-body">
            <div class="form-group">
                <label for="game_category">{{ trans('cruds.game.fields.game_category') }}</label>
                @php
                    $game_category = explode(",", $game->game_category);
                @endphp
                <select class="form-control custom_order select2_game_category {{ $errors->has('game_category') ? 'is-invalid' : '' }}" name="game_category[]" id="game_category" data-selected="{{ implode(",", $game_category) }}" multiple>
                    @foreach($game_category as $game_id)
                        @php
                            /**
                            * @var $game_id from loop
                                */
                            $gamecat = \App\GameCategory::find($game_id)
                        @endphp
                        @if($gamecat)
                            <option value="{{ $gamecat->id }}">{{ $gamecat->name }}</option>
                        @endif
                    @endforeach
                    @foreach($all_game_category as $gamecat)
                        @if($gamecat && !in_array($gamecat->id, $game_category))
                            <option value="{{ $gamecat->id }}">{{ $gamecat->name }}</option>
                        @endif
                    @endforeach
                </select>
                @if($errors->has('game_category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('game_category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.game_category_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="similar_games">{{ trans('cruds.game.fields.similar_games') }}</label>
                @php
                    $similar_games = explode(",", $game->similar_games);
                @endphp
                <select class="form-control custom_order select2_similar_games {{ $errors->has('similar_games') ? 'is-invalid' : '' }}" name="similar_games[]" id="similar_games" data-selected="{{ implode(",", $similar_games) }}" multiple>
                    @foreach($all_similar_games as $similargame)
                        @if($similargame && !in_array($similargame->id, $similar_games))
                            <option value="{{ $similargame->id }}">{{ $similargame->name }} - {{$similargame->provider}}</option>
                        @endif
                    @endforeach
                </select>
                @if($errors->has('similar_games'))
                    <div class="invalid-feedback">
                        {{ $errors->first('similar_games') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.similar_games_helper') }}</span>
            </div>



            <div class="form-group">
                <label for="logo">{{ trans('cruds.game.fields.logo') }} (upload in 1:1 ratio, recommended size  120*120)</label>
                <div class="needsclick dropzone {{ $errors->has('logo') ? 'is-invalid' : '' }}" id="logo-dropzone">
                </div>
                @if($errors->has('logo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('logo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.logo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="logo_alt_text">{{ trans('cruds.game.fields.logo_alt_text') }}</label>
                <input class="form-control {{ $errors->has('logo_alt_text') ? 'is-invalid' : '' }}" type="text" name="logo_alt_text" id="logo_alt_text" value="{{ old('logo_alt_text', $game->logo_alt_text) }}">
                @if($errors->has('logo_alt_text'))
                    <div class="invalid-feedback">
                        {{ $errors->first('logo_alt_text') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.logo_alt_text_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="color_picker">{{ trans('cruds.casino.fields.color_picker') }}</label>
                <input id="swatches" class="form-control demo" name="bg_color" data-swatches="#ef9a9a|#90caf9|#a5d6a7|#fff59d|#ffcc80|#bcaaa4|#eeeeee|#f44336|#2196f3|#4caf50|#ffeb3b|#ff9800|#795548|#9e9e9e" value="{{ old('bg_color', $game->bg_color) }}">
                @if($errors->has('color_picker'))
                    <div class="invalid-feedback">
                        {{ $errors->first('color_picker') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.casino.fields.color_picker_helper') }}</span>
            </div>
            {{-- <div class="form-group">
                <label for="bg_image">{{ trans('cruds.game.fields.bg_image') }} (recommended size  1920*400)</label>
                <div class="needsclick dropzone {{ $errors->has('bg_image') ? 'is-invalid' : '' }}" id="bg_image-dropzone">
                </div>
                @if($errors->has('bg_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bg_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.bg_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bg_image_alt_text">{{ trans('cruds.game.fields.bg_image_alt_text') }}</label>
                <input class="form-control {{ $errors->has('bg_image_alt_text') ? 'is-invalid' : '' }}" type="text" name="bg_image_alt_text" id="bg_image_alt_text" value="{{ old('bg_image_alt_text', $game->bg_image_alt_text) }}">
                @if($errors->has('bg_image_alt_text'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bg_image_alt_text') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.bg_image_alt_text_helper') }}</span>
            </div> --}}
            <div class="form-group">
                <label for="bg_image_logo">{{ trans('cruds.game.fields.bg_image_logo') }} (recommended size   max-width:300px & max-height:200px)</label>
                <div class="needsclick dropzone {{ $errors->has('bg_image_logo') ? 'is-invalid' : '' }}" id="bg_image_logo-dropzone">
                </div>
                @if($errors->has('bg_image_logo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bg_image_logo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.bg_image_logo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bg_image_logo_alt_text">{{ trans('cruds.game.fields.bg_image_logo_alt_text') }}</label>
                <input class="form-control {{ $errors->has('bg_image_logo_alt_text') ? 'is-invalid' : '' }}" type="text" name="bg_image_logo_alt_text" id="bg_image_logo_alt_text" value="{{ old('bg_image_logo_alt_text', $game->bg_image_logo_alt_text) }}">
                @if($errors->has('bg_image_logo_alt_text'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bg_image_logo_alt_text') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.bg_image_logo_alt_text_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bg_image_text">{{ trans('cruds.game.fields.bg_image_text') }}</label>
                <input class="form-control {{ $errors->has('bg_image_text') ? 'is-invalid' : '' }}" type="text" name="bg_image_text" id="bg_image_text" value="{{ old('bg_image_text', $game->bg_image_text) }}">
                @if($errors->has('bg_image_text'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bg_image_text') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.bg_image_text_helper') }}</span>
            </div>
            {{-- <div class="form-group">
                <label for="bg_image_button_text">{{ trans('cruds.game.fields.bg_image_button_text') }}</label>
                <input class="form-control {{ $errors->has('bg_image_button_text') ? 'is-invalid' : '' }}" type="text" name="bg_image_button_text" id="bg_image_button_text" value="{{ old('bg_image_button_text', $game->bg_image_button_text) }}">
                @if($errors->has('bg_image_button_text'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bg_image_button_text') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.bg_image_button_text_helper') }}</span>
            </div> --}}
            {{--<div class="form-group">
                <label for="bg_image_button_link">{{ trans('cruds.game.fields.bg_image_button_link') }}</label>
                <input class="form-control {{ $errors->has('bg_image_button_link') ? 'is-invalid' : '' }}" type="text" name="bg_image_button_link" id="bg_image_button_link" value="{{ old('bg_image_button_link', $game->bg_image_button_link) }}">
                @if($errors->has('bg_image_button_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bg_image_button_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.bg_image_button_link_helper') }}</span>
            </div>--}}
            <div class="form-group">
                <label for="game_link">{{ trans('cruds.game.fields.game_link') }}</label>
                <textarea class="form-control {{ $errors->has('game_link') ? 'is-invalid' : '' }}" name="game_link" placeholder="http://abc.com" id="game_link" >{{ old('game_link', $game->game_link) }}</textarea>
                @if($errors->has('game_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('game_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.game_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.game.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $game->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rtp_game">{{ trans('cruds.game.fields.rtp_game') }}</label>
                <input class="form-control {{ $errors->has('rtp_game') ? 'is-invalid' : '' }}" type="text" name="rtp_game" id="rtp_game" value="{{ old('rtp_game', $game->rtp_game) }}">
                @if($errors->has('rtp_game'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rtp_game') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.rtp_game_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="layout">{{ trans('cruds.game.fields.layout') }}</label>
                <input class="form-control {{ $errors->has('layout') ? 'is-invalid' : '' }}" type="text" name="layout" id="layout" value="{{ old('layout', $game->layout) }}">
                @if($errors->has('layout'))
                    <div class="invalid-feedback">
                        {{ $errors->first('layout') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.layout_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="gevinstlinjer">{{ trans('cruds.game.fields.gevinstlinjer') }}</label>
                <input class="form-control {{ $errors->has('gevinstlinjer') ? 'is-invalid' : '' }}" type="text" name="gevinstlinjer" id="gevinstlinjer" value="{{ old('gevinstlinjer', $game->gevinstlinjer) }}">
                @if($errors->has('gevinstlinjer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gevinstlinjer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.gevinstlinjer_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="maks_mynt_gevinst">{{ trans('cruds.game.fields.maks_mynt_gevinst') }}</label>
                <input class="form-control {{ $errors->has('maks_mynt_gevinst') ? 'is-invalid' : '' }}" type="text" name="maks_mynt_gevinst" id="maks_mynt_gevinst" value="{{ old('maks_mynt_gevinst', $game->maks_mynt_gevinst) }}">
                @if($errors->has('maks_mynt_gevinst'))
                    <div class="invalid-feedback">
                        {{ $errors->first('maks_mynt_gevinst') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.maks_mynt_gevinst_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="volatilitet_game">{{ trans('cruds.game.fields.volatilitet_game') }}</label>
                <input class="form-control {{ $errors->has('volatilitet_game') ? 'is-invalid' : '' }}" type="text" name="volatilitet_game" id="volatilitet_game" value="{{ old('volatilitet_game', $game->volatilitet_game) }}">
                @if($errors->has('volatilitet_game'))
                    <div class="invalid-feedback">
                        {{ $errors->first('volatilitet_game') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.volatilitet_game_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="min_innsats">{{ trans('cruds.game.fields.min_innsats') }}</label>
                <input class="form-control {{ $errors->has('min_innsats') ? 'is-invalid' : '' }}" type="text" name="min_innsats" id="min_innsats" value="{{ old('min_innsats', $game->min_innsats) }}">
                @if($errors->has('min_innsats'))
                    <div class="invalid-feedback">
                        {{ $errors->first('min_innsats') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.min_innsats_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="maks_innsats">{{ trans('cruds.game.fields.maks_innsats') }}</label>
                <input class="form-control {{ $errors->has('maks_innsats') ? 'is-invalid' : '' }}" type="text" name="maks_innsats" id="maks_innsats" value="{{ old('maks_innsats', $game->maks_innsats) }}">
                @if($errors->has('maks_innsats'))
                    <div class="invalid-feedback">
                        {{ $errors->first('maks_innsats') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.maks_innsats_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.game.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $game->description) !!}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="provider">{{ trans('cruds.game.fields.provider') }}</label>
                <select class="form-control select2 {{ $errors->has('provider') ? 'is-invalid' : '' }}" name="provider" id="provider">
                  <option value="" hidden>Please select one</option>
                  @foreach($all_providers as $provider)
                    <option value="{{$provider->title}}" {{ old('provider', $game->provider)=="$provider->title"? 'selected':'' }}>{{$provider->title}}</option>
                  @endforeach
                </select>
                @if($errors->has('provider'))
                    <div class="invalid-feedback">
                        {{ $errors->first('provider') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.provider_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rtp">{{ trans('cruds.game.fields.rtp') }}</label>
                <select class="form-control select2 {{ $errors->has('rtp') ? 'is-invalid' : '' }}" name="rtp" id="rtp">
                    <option value="Low" {{ old('rtp', $game->rtp)=="Low"? 'selected':'' }}>Low</option>
                    <option value="Medium" {{ old('rtp', $game->rtp)=="Medium"? 'selected':'' }}>Medium</option>
                    <option value="High" {{ old('rtp', $game->rtp)=="High"? 'selected':'' }}>High</option>
                </select>
                @if($errors->has('rtp'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rtp') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.rtp_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="volatilitet">{{ trans('cruds.game.fields.volatilitet') }}</label>
                <select class="form-control select2 {{ $errors->has('volatilitet') ? 'is-invalid' : '' }}" name="volatilitet" id="volatilitet">
                    <option value="Low" {{ old('volatilitet', $game->volatilitet)=="Low"? 'selected':'' }}>Low</option>
                    <option value="Medium" {{ old('volatilitet', $game->volatilitet)=="Medium"? 'selected':'' }}>Medium</option>
                    <option value="High" {{ old('volatilitet', $game->volatilitet)=="High"? 'selected':'' }}>High</option>
                </select>
                @if($errors->has('volatilitet'))
                    <div class="invalid-feedback">
                        {{ $errors->first('volatilitet') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.volatilitet_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="gpi">{{ trans('cruds.game.fields.gpi') }}</label>
                <select class="form-control select2 {{ $errors->has('gpi') ? 'is-invalid' : '' }}" name="gpi" id="gpi">
                    <option value="Low" {{ old('gpi', $game->gpi)=="Low"? 'selected':'' }}>Low</option>
                    <option value="Medium" {{ old('gpi', $game->gpi)=="Medium"? 'selected':'' }}>Medium</option>
                    <option value="High" {{ old('gpi', $game->gpi)=="High"? 'selected':'' }}>High</option>
                </select>
                @if($errors->has('gpi'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gpi') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.gpi_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="popular_casino_heading">{{ trans('cruds.game.fields.popular_casino_heading') }}</label>
                <input class="form-control {{ $errors->has('popular_casino_heading') ? 'is-invalid' : '' }}" type="text" name="popular_casino_heading" id="popular_casino_heading" value="{{ old('popular_casino_heading', @$game->popular_casino_heading) }}">
                @if($errors->has('popular_casino_heading'))
                    <div class="invalid-feedback">
                        {{ $errors->first('popular_casino_heading') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.popular_casino_heading_helper') }}</span>
            </div>

            {{--<div class="form-group">
                <label for="popular_casino">{{ trans('cruds.game.fields.popular_casino') }}</label>
                @php
                    $popular_casinos = explode(",", $game->popular_casinos)
                @endphp
                <select class="form-control custom_order select2_popular_casinos {{ $errors->has('popular_casinos') ? 'is-invalid' : '' }}" name="popular_casinos[]" id="popular_casinos" data-selected="{{ implode(",", $popular_casinos) }}" multiple>
                    @foreach($popular_casinos as $casino_id)
                        @php
                            /**
                            * @var $casino_id from loop
                                */
                            $casino = \App\Casino::find($casino_id)
                        @endphp
                        @if($casino)
                            <option value="{{ $casino->id }}">{{ $casino->name }}</option>
                        @endif
                    @endforeach
                    @foreach($all_casinos as $casino)
                        @if($casino && !in_array($casino->id, $popular_casinos))
                            <option value="{{ $casino->id }}">{{ $casino->name }}</option>
                        @endif
                    @endforeach
                </select>
                @if($errors->has('popular_casinos'))
                    <div class="invalid-feedback">
                        {{ $errors->first('popular_casinos') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.popular_casino_helper') }}</span>
            </div>--}}

            <div class="form-group">
                <label for="slots_heading">{{ trans('cruds.game.fields.slots_heading') }}</label>
                <input class="form-control {{ $errors->has('slots_heading') ? 'is-invalid' : '' }}" type="text" name="slots_heading" value="{{ old('slots_heading', @$game->slots_heading) }}">
                @if($errors->has('slots_heading'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slots_heading') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.slots_heading_helper') }}</span>
            </div>

            {{--<div class="form-group">
                <label for="slots">{{ trans('cruds.game.fields.slots') }}</label>
                @php
                    $slots = explode(",", $game->slots);
                @endphp
                <select class="form-control custom_order select2_slots {{ $errors->has('slots') ? 'is-invalid' : '' }}" name="slots[]" id="slots" data-selected="{{ implode(",", $slots) }}" multiple>
                    @foreach($all_slots as $slots_casino)
                        @if($slots_casino && !in_array($slots_casino->id, $slots))
                            <option value="{{ $slots_casino->id }}">{{ $slots_casino->name }} - {{$slots_casino->provider}}</option>
                        @endif
                    @endforeach
                </select>
                @if($errors->has('slots'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slots') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.slots_helper') }}</span>
            </div>--}}

            <div class="form-group">
                <label for="faq_heading">{{ trans('cruds.game.fields.faq_heading') }}</label>
                <input class="form-control {{ $errors->has('faq_heading') ? 'is-invalid' : '' }}" type="text" name="faq_heading" id="v" value="{{ old('faq_heading', @$game->faq_heading) }}">
                @if($errors->has('faq_heading'))
                    <div class="invalid-feedback">
                        {{ $errors->first('faq_heading') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.faq_heading_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="faqs">{{ trans('cruds.game.fields.faq') }}</label>
                @php
                    $faqs = explode(",", $game->faqs)
                @endphp
                <select class="form-control custom_order select2_faq {{ $errors->has('faqs') ? 'is-invalid' : '' }}" name="faqs[]" id="faqs" data-selected="{{ implode(",", $faqs) }}" multiple>
                    @foreach($faqs as $faq_id)
                        @php
                            /**
                            * @var $faq_id from loop
                                */
                            $faq = \App\FaqQuestion::find($faq_id)
                        @endphp
                        @if($faq)
                            <option value="{{ $faq->id }}">{{ $faq->question }}</option>
                        @endif
                    @endforeach
                    @foreach($all_faqQuestions as $faq)
                        @if($faq && !in_array($faq->id, $faqs))
                            <option value="{{ $faq->id }}">{{ $faq->question }}</option>
                        @endif
                    @endforeach
                </select>
                @if($errors->has('faqs'))
                    <div class="invalid-feedback">
                        {{ $errors->first('faqs') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.game.fields.faq_helper') }}</span>
            </div>



        </div>
    </div>
    @php
        /**
          * @var $game `from controller`
          */
        $seo_title = $game->seo_title;
        $seo_keyword = $game->seo_keyword;
        $seo_description = $game->seo_description;
        $countries = explode(',', $game->countries);
    @endphp
    @include('partials.seoFields', compact('errors', 'seo_title', 'seo_keyword', 'seo_description'))
    {{-- @include('partials.countriesFields', compact('errors', 'countries')) --}}
    @include('partials.saveWideButton')
</form>



@endsection


@section('scripts')
    <script>
        $(document).ready(function () {
            $('select.select2_game_category').select2_sortable({
                maximumSelectionLength: 10
            });
            $('select.select2_similar_games').select2_sortable({
                maximumSelectionLength: 20
            });
            $('select.select2_popular_casinos').select2_sortable({
            });
            $('select.select2_faq').select2_sortable({
            });
            $('select.select2_slots').select2_sortable({
            });
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                    return {
                        upload: function() {
                            return loader.file
                                .then(function (file) {
                                    return new Promise(function(resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', '/en/admin/games/ckmedia', true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                                        xhr.addEventListener('error', function() { reject(genericErrorText) });
                                        xhr.addEventListener('abort', function() { reject() });
                                        xhr.addEventListener('load', function() {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                            }

                                            $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                            resolve({ default: response.url });
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function(e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', {{ $game->id ?? 0 }});
                                        xhr.send(data);
                                    });
                                })
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

    <script>
        Dropzone.options.logoDropzone = {
            url: '{{ route('admin.games.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4086,
                height: 4096
            },
            success: function (file, response) {
                $('form').find('input[name="logo"]').remove()
                $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="logo"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($game) && $game->logo)
                var file = {!! json_encode($game->logo) !!}
                        this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, '{{ $game->logo->getUrl('thumb') }}')
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
        Dropzone.options.bgImageDropzone = {
            url: '{{ route('admin.games.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4086,
                height: 4096
            },
            success: function (file, response) {
                $('form').find('input[name="bg_image"]').remove()
                $('form').append('<input type="hidden" name="bg_image" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="bg_image"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($game) && $game->bg_image)
                var file = {!! json_encode($game->bg_image) !!}
                        this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, '{{ $game->bg_image->getUrl('thumb') }}')
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="bg_image" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }

        Dropzone.options.bgImageLogoDropzone = {
            url: '{{ route('admin.games.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4086,
                height: 4096
            },
            success: function (file, response) {
                $('form').find('input[name="bg_image_logo"]').remove()
                $('form').append('<input type="hidden" name="bg_image_logo" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="bg_image_logo"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($game) && $game->bg_image_logo)
                var file = {!! json_encode($game->bg_image_logo) !!}
                        this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, '{{ $game->bg_image_logo->getUrl('thumb') }}')
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="bg_image_logo" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }

    </script>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="{{ asset('asset/admin/css/jquery.minicolors.js')}}"></script>
<script>
    $(document).ready( function() {
      $('.demo').each( function() {
        $(this).minicolors({
          control: $(this).attr('data-control') || 'hue',
          defaultValue: $(this).attr('data-defaultValue') || '',
          format: $(this).attr('data-format') || 'hex',
          keywords: $(this).attr('data-keywords') || '',
          inline: $(this).attr('data-inline') === 'true',
          letterCase: $(this).attr('data-letterCase') || 'lowercase',
          opacity: $(this).attr('data-opacity'),
          position: $(this).attr('data-position') || 'bottom',
          swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
          change: function(value, opacity) {
            if( !value ) return;
            if( opacity ) value += ', ' + opacity;
            if( typeof console === 'object' ) {
              console.log(value);
            }
          },
          theme: 'bootstrap'
        });

      });

    });
</script>
@endsection
