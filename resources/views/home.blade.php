@extends('layouts.main', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('Coffee Moment')])

@section('content')
<div class="container" style="height: auto;">
  <div class="align-items-center">
    <div class="col-lg-9 col-md-6 col-sm-8 ml-auto mr-auto mb-5">
      <form class="form" enctype="multipart/form-data" role="form">
        @csrf
        <div class="card card-login card-hidden mb-3">
          <div class="card-header card-header-primary text-center">
            @if($userAvatar)
              <img src="{{asset('img/faces/'.$userAvatar)}}" class="avatar publish" width="100" height="100">
            @else
              <img src="{{asset('img/faces/cover.jpg')}}" class="avatar publish">
            @endif
            <h3 class="card-title"><strong>{{ __('Publicar') }}</strong></h3>
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
              <div>
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <button type="button" class="btn btn-primary" id="addImage">
                      <i class="material-icons">image</i> Añadir una foto
                    </button>
                  </span>
                </div>
                <div id="divImage" style="display: none" class="ml-auto mr-auto">
                  <input type="file" name="imagenUpload" id="imagenUpload" class="imageUpload" accept="image/png, .jpeg, .jpg"/>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer justify-content-center">
            <button type="button" class="btn btn-primary btn-link btn-lg" id="enviarPost">
              <i class="material-icons">send</i> {{ __('Publicar') }}
          </button>
          </div>
        </div>
      </form>
    </div>

    @foreach($posts as $p)
      <div class="col-lg-9 col-md-6 col-sm-8 ml-auto mr-auto" id="{{"idPub-".$p->id}}">
        <div class="card card-login card-hidden mb-5">
          <div class="card-header card-header-primary text-center">
            @if($p->avatar)
              <a href="{{'profile/'.$p->author}}"><img src="{{asset('img/faces/'.$p->avatar)}}" class="avatar" width="100" height="100"></a>
            @else
            <a href="{{'profile/'.$p->author}}"><img src="{{asset('img/faces/marc.jpg')}}" class="avatar"></a>
            @endif
            <h3 class="card-title titleAutor"><strong>{{$p->author}}</strong></h3>
            @if(Auth::user()->name == $p->author)
              <div class="buttonsCards">
                  <i class="btn btn-white btn-round btn-delete" data-title="Eliminar" data-target="{{$p->id}}" data-id="{{Crypt::encrypt($p->id)}}"><i class="material-icons">delete</i></i>
                  <input id="contentEdit{{$p->id}}" name="contentEdit{{$p->id}}" value="" hidden>
                  <i class="btn btn-white btn-round btn-edit" data-title="Editar" data-id="{{$p->id}}" data-idcifrado="{{Crypt::encrypt($p->id)}}"><i class="material-icons">edit</i></i>
              </div>
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
              @if($p->image)
                <div class="mt-3">
                  <img src="{{asset('img/posts/'.$p->image)}}" width="765" height="280" class="postImages">
                </div>
              @endif
              @if ($errors->has('contentEdit'.$p->id))
                <div id="contentEdit-error{{$p->id}}" class="error text-danger pl-3" for="contentEdit" style="display: block;">
                  <strong>{{ $errors->first('contentEdit'.$p->id) }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="card-footer justify-content-center">
            <button type="button" class="btn btn-primary btn-link btn-lg btn-save" id="btn-save{{$p->id}}" data-id="{{$p->id}}" data-idcifrado="{{Crypt::encrypt($p->id)}}" style="display: none"><i class="material-icons">send</i> {{ __('Guardar') }}</button>
            @if(strlen($p->like_user) > 1 && in_array(Auth::user()->id,  explode("-", $p->like_user)))
              <button type="button" class="btn btn-primary btn-link btn-lg btn-like" data-id="{{$p->id}}"><i class="material-icons">favorite</i> <i>{{$p->likes}} {{ __('ME GUSTA') }}</i></button>
            @elseif(strlen($p->like_user) == 1 && Auth::user()->id == $p->like_user)
              <button type="button" class="btn btn-primary btn-link btn-lg btn-like" data-id="{{$p->id}}"><i class="material-icons">favorite</i> <i>{{$p->likes}} {{ __('ME GUSTA') }}</i></button>
            @else
              <button type="button" class="btn btn-primary btn-link btn-lg btn-like" data-id="{{$p->id}}"><i class="material-icons" style="color: grey">favorite</i> <i>{{$p->likes}} {{ __('ME GUSTA') }}</i></button>
            @endif
          </div>
        </div>
      </div>
    @endforeach

  </div>
</div>
@endsection