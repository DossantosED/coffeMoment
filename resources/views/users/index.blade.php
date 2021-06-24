@extends('layouts.main', ['class' => 'off-canvas-sidebar', 'activePage' => 'index', 'title' => __('Coffee Moment')])

@section('content')
<div class="container" style="height: auto;">
  <div class="align-items-center">
    <div class="col-lg-6 col-md-6 col-sm-8 ml-auto mr-auto">
      <form class="form" method="POST" action="postCreate">
        @csrf
        <div class="card card-login card-hidden mb-3">
          <div class="card-header card-header-primary text-center">
            <h4 class="card-title"><strong>{{ __('Publicar') }}</strong></h4>
            <div class="social-line">
              <span class="material-icons">local_cafe</span>
            </div>
          </div>
          <div class="card-body">
            <p class="card-description text-center">{{ __('Crear publicación') }}</p>
            <div class="bmd-form-group{{ $errors->has('content') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">post_add</i>
                  </span>
                </div>
                <textarea name="content" id="content" class="form-control" placeholder="{{ __('¿Como te sientes hoy?') }}" value="{{ old('content', '') }}" required autocomplete="content"></textarea>
              </div>
              @if ($errors->has('content'))
                <div id="content-error" class="error text-danger pl-3" for="content" style="display: block;">
                  <strong>{{ $errors->first('content') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="card-footer justify-content-center">
            <button type="submit" class="btn btn-primary btn-link btn-lg"><i class="material-icons">send</i> {{ __('Publicar') }}</button>
          </div>
        </div>
      </form>
    </div>

    @foreach($posts as $p)
      <div class="col-lg-6 col-md-6 col-sm-8 ml-auto mr-auto">
        <div class="card card-login card-hidden mb-3">
          <div class="card-header card-header-primary text-center">
            <h4 class="card-title"><strong>{{$p->author}}</strong></h4>
            <div class="social-line">
              <span class="material-icons">local_cafe</span>
            </div>
          </div>
          <div class="card-body">
            <p class="card-description text-center">Publicado el: {{$p->created_at}}</p>
            <div class="bmd-form-group{{ $errors->has('content') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">event</i>
                  </span>
                </div>
                {{$p->content}}
              </div>
            </div>
          </div>
          <div class="card-footer justify-content-center">
            <button type="button" class="btn btn-primary btn-link btn-lg"><i class="material-icons">favorite</i> {{ __('Me gusta') }}</button>
          </div>
        </div>
      </div>
    @endforeach

  </div>
</div>
@endsection