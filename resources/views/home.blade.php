@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Dernière nouvelle de nos politiciens :</div>
            <div class="panel-body">
                @include('layouts.homepagePanel',['data'=>$weekPoliticians,'title'=>"Cette semaine"])
                @include('layouts.homepagePanel',['data'=>$monthPoliticians,'title'=>"Ce mois-ci"])
                @include('layouts.homepagePanel',['data'=>$yearPoliticians,'title'=>"Cette année - ".date('Y')])
                @include('layouts.homepagePanel',['data'=>$lastyearPoliticians,'title'=>"L'année passée - ".date('Y', strtotime('-1 year'))])
            </div>
        </div>
    </div>
</div>
@endsection
