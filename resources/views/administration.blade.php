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
                    for(search in e){
                        console.log(e[search]);
                        for(searchWord in searchWords){
                            var item = searchWords[searchWord];
                            if(e[search].titre !== null){
                                e[search].titre= e[search].titre.replaceAll(item, "<span class='underline'>"+item+"</span>");
                            }
                            if(e[search].article !== null){
                                e[search].article = e[search].article.replaceAll(item, "<span class='underline'>"+item+"</span>");
                            }
                            else{
                                // if(e[search].description !== null){
                                //     e[search].article.replaceAll(e[search].description, "<span class='underline'>"+e[search].description+"</span>");
                                // }
                            }
                        }
                        html += "<tr>"
                        html +=     "<td>"+e[search].media+"</td>";
                        html +=     "<td>"+
                                        "<a href='"+e[search].lien+"'>"+
                                            e[search].titre +
                                        "</a>"+
                                        "<span style='cursor:pointer' class='glyphicon glyphicon-triangle-bottom displayArticle'></span>"+
                                        "<div class='toggle article'>"+
                                            e[search].article +
                                        "</div>" + 
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

        $('body').on('click','.displayArticle', function(){
            $(this).parent('td').children('.toggle').toggleClass('article');
        })
    </script>
@endsection