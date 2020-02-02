@extends('layouts.app')
@section('stylesheet')
    <style>
        .article{
            position: relative;
            /* min-height: 200px; */
        }
        .politicianImg{
            position: relative;
            float: left;
            width:  200px;
            height: 200px;
            background-position: 50% 50%;
            background-repeat:   no-repeat;
            background-size:     cover;
        }
        .category{
            position:relative;
            left:0;
            bottom:0;
            width: 100%;
        }
        .category span{
            margin-left: 5px;
            min-width:90%;
            font-size: 0.8em;
        }
        .row{
            margin: 10px;
        }
        hr {
            -moz-border-bottom-colors: none;
            -moz-border-image: none;
            -moz-border-left-colors: none;
            -moz-border-right-colors: none;
            -moz-border-top-colors: none;
            border-color: #EEEEEE -moz-use-text-color #FFFFFF;
            border-style: solid none;
            border-width: 1px 0;
            margin: 18px 0;
            position: relative
            bottom: 0;;
        }
    </style>
@endsection
@section('content')
{{-- <div class="container"> --}}
    <div class="row">
        <div class="jumbotron">
            <h3>@lang("Liste des politiciens")</h3>
            <div class="text-right">
                <h4>Nombre total de politiciens           : {{$countPoliticanTot}}</h4>
                <h4>Nombre de politiciens avec articles   : {{$countPoliticanArt}}</h4>
            </div>
        </div>
        @include('layouts.searchForm', ['route' => route('politician.index')])
            @foreach($politicians as $i=>$politician)
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 article">
                <h4>{{ $loop->index +1 + $politicians->perPage() * ($politicians->currentPage() - 1) }}. {{ $politician->firstname}} {{ $politician->lastname}}
                <a href="{{ route('politician.show', [$politician->id]) }}">
                    <div class="text-right">
                        <button type="button" class="btn btn-primary">
                            Articles
                            <span class="badge badge-light">{{ count($politician->articles) }}</span>
                        </button>
                    </div>
                </a>
                </h4>
                {{-- Bouton + dernier article --}}
                @if(count($politician->articles) > 0)
                        <img class="politicianImg" src="{{ ($politician->image != null)?$politician->image: asset('images/politicians/defaultImg.png') }}" alt="" >
                        <div class="category">
                            <span class="label label-primary">Famille</span>
                            <span class="label label-default">Justice</span>
                            <span class="label label-primary">Mobilité</span>
                            <span class="label label-default">Santé</span>
                            <span class="label label-primary">Environnement</span>
                            <span class="label label-default">Logement</span>
                            <span class="label label-primary">Economie</span>
                            <span class="label label-default">Formation</span>
                            <span class="label label-primary">Emploi</span>
                        </div>   
                @endif
            </div>
            {{-- <hr> --}}
            @endforeach
        </div>                                    
    </div>
    <div class="text-center">
            {{ $links }}
    </div>
{{-- </div> --}}
@endsection
@section('script')
    {{-- <script>
        $(document).ready(function(){
            $('#submit').on('click', function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('politician.index')}}",
                    data: {
                        lastname: $('#lastname').attr('id'),
                        firstname: $('#firstname').attr('id')
                    },
                    success: function(e){console.log(e);},
                    error: function(e){console.log(e);}
                });
            })
        })
    </script> --}}
@endsection
