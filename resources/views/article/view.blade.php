@extends('layouts.app')
@section('stylesheet')
@endsection

@section('content')
    <div class="container">
        <div class="jumbotron header-pol" style="min-height:20vh;">
            <div class="image-pol container">
                <h3 style="position:relative;float:left;"><span class="label label-primary">{{ $article[0]->media }}</span></h3>
                <h3 style="position:relative;float:left;">
                    {{ $article[0]->titre }}
                </h3>
                <h3 style="float:right"><span class="badge">{{ strftime("%A %d %B %G", strtotime($article[0]->date)) }}</span></h3>
                {{-- <img src="{{ $article[0]->image }}" alt="" style="max-width:30vh; float:right;"> --}}
           </div>
        </div>

        <div class="body-pol">
           <div class="description" style="margin:0 5vw;text-align:justify">
                <a href="{{ $article[0]->lien }}" target="_blank">
                    <p>
                        @if($article[0]->article == "")
                            {{ $article[0]->description }}
                        @else {{ $article[0]->article }}
                        @endif
                    </p>
                </a>
                
           </div>
            <div class="articles-pol">
                <div class="pull-right">
                    @foreach($article[0]->politicians as $politician)
                        <span class="label label-primary">
                            <a href="{{ route('politician.show', [$politician->id]) }}" style="color:white;">
                                {{ $politician->firstname}} {{ $politician->lastname}}
                            </a>
                        </span>
                    @endforeach
                </div>         
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection