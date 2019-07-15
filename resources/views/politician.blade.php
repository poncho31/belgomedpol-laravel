@extends('layouts.app')
@section('stylesheet')
    <style>
        .bottom{
            position: relative;
            bottom: 0;
            left: 0;
        }
        .article{
            position: relative;
            min-height: 200px;
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
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="jumbotron">
            <h3>@lang("Liste des politiciens")</h3>
        </div>
        @include('layouts.searchForm', ['route' => route('politician.index')])
            @foreach($politicians as $i=>$politician)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 article">
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
                        <img class="politicianImg" src="{{ ($politician->image != null)?$politician->image:asset('images/politicians/defaultImg.png') }}" alt="" >
                        <div class="bottom">
                            <div class="pull-left">
                                <span class="label label-default">alice</span>
                                <span class="label label-default">story</span>
                                <span class="label label-default">blog</span>
                                <span class="label label-default">personal</span>
                                <span class="label label-default">Warning</span>
                                <span class="label label-default">Danger</span>
                            </div>   
                            <hr>
                        </div>
                @endif
                
            </div>
            @endforeach
        </div>                                    
    </div>
    <div class="text-center">
            {{ $links }}
    </div>
</div>
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
