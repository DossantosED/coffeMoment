@extends('layouts.main', ['class' => 'off-canvas-sidebar', 'activePage' => 'index', 'title' => __('Coffee Moment')])

@section('content')
<div class="banner col-lg-12 col-md-6 col-sm-8 ml-auto mr-auto">
    <img src="{{asset('img/faces/marc.jpg')}}" alt="Derek" class="avatar" id="avatar">
    <i class="material-icons btn btn-white btn-round btn-just-icon" id="editAvatar">edit</i>
  <img src="{{asset('img/cover.jpg')}}" class="banner-img">
</div>
<div class="container" style="height: auto;">
  <div class="align-items-center" style="margin-top: 25rem">
    @if(Auth::user()->name == $posts["user"])
      <div class="col-lg-6 col-md-6 col-sm-8 ml-auto mr-auto mb-5">
        <form class="form" method="POST" action="/postCreate" id="postCreate">
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
                  <textarea name="content" id="content" class="form-control" placeholder="{{ __('¿Como te sientes hoy?') }}" required autocomplete="content">{{ old('content', '') }}</textarea>
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
    @endif
  @if(count($posts["posts"]) > 0)
    <hr class="bg-white">
    @if(Auth::user()->name == $posts["user"])
      <h2 class="text-center">Tus publicaciones</h2>
    @else
      <h2 class="text-center">Publicaciones de {{$posts["user"]}}</h2>
    @endif
  @else
    <h2 class="text-center">No hay Publicaciones para mostrar</h2>
  @endif
  @foreach($posts["posts"] as $p)
    <div class="col-lg-6 col-md-6 col-sm-8 ml-auto mr-auto">
      <div class="card card-login card-hidden mb-5">
        <div class="card-header card-header-primary text-center">
          <img src="{{asset('img/faces/marc.jpg')}}" class="avatar">
          <h4 class="card-title"><strong>{{$p->author}}</strong></h4>
          @if(Auth::user()->name == $p->author)
            <form action="/postDelete" method="POST" id="formDelete{{$p->id}}">
              @csrf
              <input name="idPost" value="{{Crypt::encrypt($p->id)}}" hidden>
              <button type="submite" class="btn btn-white btn-round btn-just-icon btn-delete" data-placement="right" data-toggle="tooltip" title="Eliminar" data-target="{{$p->id}}"><span class="material-icons">delete</span></button>
            </form>
            <form action="/postEdit" method="POST" id="formEdit{{$p->id}}">
              <input id="contentEdit{{$p->id}}" name="contentEdit{{$p->id}}" value="" hidden>
              <input name="id" value="{{Crypt::encrypt($p->id)}}" hidden>
              @csrf
              <button type="button" class="btn btn-white btn-round btn-just-icon btn-edit" data-placement="right" data-toggle="tooltip" title="Editar" data-target="{{$p->id}}"><span class="material-icons">edit</span></button>
            </form>
          @endif

          <div class="social-line">
            <span class="material-icons">local_cafe</span>
          </div>
        </div>
        <div class="card-body">
          <p class="card-description text-center">Publicado el: {{$p->created_at}}</p>
          <div class="bmd-form-group{{ $errors->has(0) ? ' has-danger' : '' }}">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="material-icons">post_add</i>
                </span>
              </div>
              @if(Auth::user()->name == $p->author)
                <h4 id="original_content{{$p->id}}">{{$p->content}}</h4>
                <textarea id="content{{$p->id}}" class="form-control" placeholder="{{ __('¿Como te sientes hoy?') }}" required autocomplete="content" style="display: none">{{$p->content}}</textarea>
              @else
                <h4>{{$p->content}}</h4>
              @endif
            </div>
            @if ($errors->has('contentEdit'.$p->id))
              <div id="contentEdit-error{{$p->id}}" class="error text-danger pl-3" for="contentEdit" style="display: block;">
                <strong>{{ $errors->first('contentEdit'.$p->id) }}</strong>
              </div>
            @endif
          </div>
        </div>
        <div class="card-footer justify-content-center">
          <button type="button" class="btn btn-primary btn-link btn-lg" id="btn-save{{$p->id}}" style="display: none"><i class="material-icons">send</i> {{ __('Guardar') }}</button>
          <button type="button" class="btn btn-primary btn-link btn-lg"><i class="material-icons">favorite</i> {{ __('Me gusta') }}</button>
        </div>
      </div>
    </div>
  @endforeach

  </div>
</div>
@endsection