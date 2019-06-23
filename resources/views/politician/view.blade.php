@extends('layouts.app')
@section('stylesheet')
@endsection

@section('content')
<div class="container">
        <div class="jumbotron header-pol" style="min-height:40vh;">
            <div class="image-pol container">
                <h1 style="position:relative;float:left;">{{ $politician[0]->firstname }} {{ $politician[0]->lastname }}</h1>
                <img src="{{ $politician[0]->image }}" alt="" style="max-width:30vh; float:right;">
           </div>
   
           <div class="description" style="margin:0 5vw;text-align:justify">
                <a href="{{ $politician[0]->lienDescription }}" target="_blank">
                    <p>{{ $politician[0]->description }}</p>
                </a>
           </div>
        </div>

        <div class="body-pol">
            <hr>
            <div class="articles-pol">
                @foreach($politician[0]->articles as $article)
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 article">
                        <h4><strong><em><span class="label label-default">{{ $article->media}}</span> - <a href="{{ route('article.show', [$article->id]) }}">{{ $article->titre}}</a></em></strong></h4>
                        <p>{{ str_limit($article->description) }}</p>
                    <div>
                    <span class="badge">{{ strftime("%A %d %B %G", strtotime($article->date)) }}</span>
                        <div class="pull-right">
                            <span class="label label-default">alice</span>
                            <span class="label label-primary">story</span>
                            <span class="label label-success">blog</span>
                            <span class="label label-info">personal</span>
                            <span class="label label-warning">Warning</span>
                            <span class="label label-danger">Danger</span>
                        </div>         
                    </div>
                    <hr>
                </div>
                @endforeach
            </div>
            </div>
    
            <div class="pol-footer">
                Footer
            </div>
    
        </div>
    </div>    
@endsection

@section('script')
@endsection