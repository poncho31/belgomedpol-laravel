@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="jumbotron">
            <h3>@lang("Liste des articles")</h3>
        </div>
        @include('layouts.searchForm', ['route' => route('article.index')])
        <div class="col-md-8 col-md-offset-2">
            @foreach($articles as $article)
                <p>{{ $article->media}}</p>
                @foreach($article->politicians as $politician)
                    <p>{{ $politician->lastname}} {{ $politician->firstname}}</p>
                @endforeach
            @endforeach
        </div>
    </div>
    {{ $links }}

    <div class="row">

    </div>
</div>
@endsection

