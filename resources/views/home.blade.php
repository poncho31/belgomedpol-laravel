@extends('layouts.app')

@section('content')
<div class="" style="margin:5px">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Dernière nouvelle de nos politiciens :</div>
        </div>
        <div class="row">
            @include('layouts.homepagePanel',['data'=>$weekPoliticians,'title'=>"Cette semaine"])
            @include('layouts.homepagePanel',['data'=>$monthPoliticians,'title'=>"Ce mois-ci"])
            @include('layouts.homepagePanel',['data'=>$yearPoliticians,'title'=>"Cette année - ".date('Y')])
            @include('layouts.homepagePanel',['data'=>$lastyearPoliticians,'title'=>"L'année passée - ".date('Y', strtotime('-1 year'))])
        </div>
    </div>
@endsection
