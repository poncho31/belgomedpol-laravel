
    
<div class="col-xs-12 col-md-6 col-lg-6"  style="border:1px solid #007BFF;border-bottom:0px solid transparent;padding:5px; margin-top:5px">
    <div class="jumbotron text-center" style="width:100%;border:1px solid #959595;"><strong>{{ $title }}</strong></div>
        @foreach($data as $nb => $politician) 
        <div style="border-bottom:1px solid #007BFF; margin-top:10px;" class="clearfix">
            <div class="text-center" >
                {{ $nb + 1 }}. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span style="font-weight:bold;">
                    {{$politician->firstname}} {{$politician->lastname}}
                </span>
            </div><br>
            <div style="display:flex">
                <div style="margin:5px">
                    <img src="{{ $politician->image }}"
                        onerror="this.onerror=null;this.src='{{asset('images/politicians/defaultImg.png')}}';"
                        height="100"
                        alt="{{$politician->firstname}} {{$politician->lastname}}"
                    />
                </div>
                <div>
                    {{ $politician->description }}
                </div>
            </div>
             <div class="text-center">
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
             </div>

        </div>
        @endforeach
    </div>
    
    
    
    {{-- <div class="col-xs-12 col-md-6 col-lg-6" style="border:5px solid #EEEEEE" >
        
        
        <ul class="list-group">
            <li class="list-group-item d-flex ">
                <div class="text-center" >
                    {{ $nb + 1 }}. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span style="font-weight:bold;">
                        {{$politician->firstname}} {{$politician->lastname}}
                    </span>
                </div><br>

                 <object data="{{ $politician->image }}" type="image/png">
                    <img src="{{asset('images/politicians/defaultImg.png')}}"
                        style="object-fit: contain;max-height:10%;"
                        alt="{{$politician->firstname}} {{$politician->lastname}}"
                    />
                   </object>
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
    </div> --}}