@section('head')
@stop

@section('main')

@if($errors->has())
<div class="alert alert-warning">
    @foreach ($errors->all() as $error)
    {{ $error }}<br />
    @endforeach
</div>
@endif

@if (Session::get('success'))
<div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif

<header class="row">
    <h2 class="col-xs-12">
        {{ $article->article_name or 'No Article Name' }}
    </h2>
</header>
<section>
    @include('admin._form')
</section>
@stop
