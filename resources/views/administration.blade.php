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
    COMPTE
    <table id="count"></table>
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
                    var countMedia = e['countMedia'];
                    var globalSearch = e['globalSearch'];
                    // GLOBAL SEARCH
                    var listColorSearch = ["#0275d8", "#5cb85c", "#5bc0de", "#f0ad4e", "#d9534f", "#292b2c"];
                    for(search in globalSearch){
                        for(searchWord in searchWords){
                            console.log(globalSearch[search]);

                            var item = searchWords[searchWord];
                            var pattern = new RegExp(item,"ig");

                            if(globalSearch[search].titre !== null){
                                globalSearch[search].titre= globalSearch[search].titre.replaceAll(pattern, "<span style='background-color:"+listColorSearch[searchWord]+";color:white'>"+item+"</span>");
                            }
                            if(globalSearch[search].article !== null){
                                globalSearch[search].article = globalSearch[search].article.replaceAll(pattern, "<span style='background-color:"+listColorSearch[searchWord]+";color:white'>"+item+"</span>");
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


                    // COUNT MEDIA
                    html ="<tr><th>Media</th><th>Année</th><th>Mois</th><th>Nombre</th></tr>";
                    for( media in countMedia){
                        var item = countMedia[media];
                        html+="<tr>";
                        html+="<td>"+item.media+"</td>";
                        html+="<td>"+item.year+"</td>";
                        html+="<td>"+item.month+"</td>";
                        html+="<td>"+item.cnt+"</td>";
                        html+="<tr/>";
                    }
                    $("#count").html(html);
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