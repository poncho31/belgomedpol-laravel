@extends('layouts.app')

@section('stylesheet');
<style>
    body{
        background-color: white;
    }
    .underline{
        background-color:rgb(238, 68, 38);
        color:white;
        padding: 1px;
    }
    table{
        width: 70%;
        text-align: center
    }
    .article{
        display:none;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
@endsection
@section('content')
<div class="container-fluid">
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
</div>
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
            var searchWords = formData.get('GlobalSearch').split(';');
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
                    console.log(e);
                    var globalSearch = e['globalSearch'];
                    for(search in globalSearch){
                        for(searchWord in searchWords){
                            console.log(globalSearch[search]);
                            var item = searchWords[searchWord];
                            if(globalSearch[search].titre !== null){
                                globalSearch[search].titre= globalSearch[search].titre.replaceAll(item, "<span class='underline'>"+item+"</span>");
                            }
                            if(globalSearch[search].article !== null){
                                globalSearch[search].article = globalSearch[search].article.replaceAll(item, "<span class='underline'>"+item+"</span>");
                            }
                            else{
                                // if(globalSearch[search].description !== null){
                                //     globalSearch[search].article.replaceAll(globalSearch[search].description, "<span class='underline'>"+globalSearch[search].description+"</span>");
                                // }
                            }
                        }
                        html += "<tr>"
                        html +=     "<td>"+globalSearch[search].media+"</td>";
                        html +=     "<td>"+
                                        "<a href='"+globalSearch[search].lien+"'>"+
                                            globalSearch[search].titre +
                                        "</a>"+
                                        "<span style='cursor:pointer' class='glyphicon glyphicon-triangle-bottom displayArticle'></span>"+
                                        "<div class='toggle article'>"+
                                            globalSearch[search].article +
                                        "</div>" + 
                                    "</td>";
                        html +=     "<td>"+globalSearch[search].date+"</td>";
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

        $('body').on('click','.displayArticle', function(){
            $(this).parent('td').children('.toggle').toggleClass('article');
        })
    </script>
@endsection