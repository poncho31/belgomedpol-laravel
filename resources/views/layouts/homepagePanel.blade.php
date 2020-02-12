
    <div class="col-xs-12 col-md-6 col-lg-6" style="border:5px solid #EEEEEE">
        <div class="jumbotron text-center" style="width:100%;"><strong>{{ $title }}</strong></div>
        @foreach($data as $nb => $politician) 
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="text-center" >
                    {{ $nb + 1 }}. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span style="font-weight:bold;">
                        {{$politician->firstname}} {{$politician->lastname}}
                    </span>
                </div><br>
                <img src=" {{ $politician->image }} "
                style="object-fit: contain;"
                alt="{{$politician->firstname}} {{$politician->lastname}}"
                width="20%"
                {{-- min-height="20%" --}}
                 >
                 <br>
                 <span class="badge badge-danger badge-pill">
                     <a href="" style="color:white">
                        {{ $politician->cnt }} <small>articles</small>
                    </a>
                </span>
                <span class="badge badge-danger badge-pill">
                    <a href="" style="color:white">
                        {{ $politician->cnt - 13 }} <small>analyses</small>
                    </a>
                </span>
            </li>
        </ul>
        @endforeach
        <br><br>
    </div>