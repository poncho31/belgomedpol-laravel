@extends('layouts.app')

@section('stylesheet');
<style>
    .underline{
        background-color:rgb(238, 68, 38);
        color:white;
        padding: 1px;
    }
    table{
        width: 100%;
    }
</style>
@endsection
@section('content')

    <form action="{{ url('administration/search') }}">
        <input type="text" name="GlobalSearch" placeholder="Mot recherché">
        <input type="submit" value="Search">
    </form>
    <table>
        <tr>
            <th>Media</th>
            <th>titre</th>
            <th>Date</th>
        </tr>
        <tbody id="search">
            
        </tbody>
    </table>
@endsection

@section('script')
    <script>
       
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('form').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData(this);
            var searchWord = formData.get('GlobalSearch');
            console.log(search);
            $.ajax({
                method: 'POST',
                url: '{{ url("administration/search") }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function(e){
                    console.log("success");
                    var html = "";
                    // test = "test de test tu es test que tutest".replaceAll('test', "<span style='color:red'>test</span>")
                    // console.log(test);
                    for(search in e){
                        html += "<tr>"
                        html +=     "<td>"+e[search].media+"</td>";
                        html +=     "<td>"+
                                        "<a href='"+e[search].lien+"'>"+
                                            e[search].titre.replaceAll(searchWord, "<span class='underline'>"+searchWord+"</span>") +
                                        "</a>"+
                                    "</td>";
                        html +=     "<td>"+e[search].date+"</td>";
                        html += "</tr>";
                    }
                    // console.log();
                    $("#search").html(html);
                },
                error: function(e){
                    console.log("error",e);
                }
            })
        })
    </script>
@endsection