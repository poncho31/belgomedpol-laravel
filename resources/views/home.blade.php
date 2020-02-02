@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Latest news</div>
        </div>
        <div class="panel-body">
            <div class="col-xs-6 col-md-6 col-lg-6">
                <div class="jumbotron text-center">Politicians</div>
                @foreach($latestPoliticians as $key => $politician)
                    <div >
                        {{ $key + 1 }} {{$politician->firstname}} {{$politician->lastname}}
                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-6 text-center">
                        Nb articles : {{ count($politician->articles) }}
                    </div>
                @endforeach
            </div>
            <div class="col-xs-6 col-md-6 col-lg-6">
                <div class="jumbotron text-center">Articles</div>
                @foreach($latestArticles as $article)
                <div class="col-xs-12 col-md-6 col-lg-6 text-center">TEST</div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
