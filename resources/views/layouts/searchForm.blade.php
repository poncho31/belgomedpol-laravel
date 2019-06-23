<div class="container">
    <form action="{{ $route }}" method="GET">
        <div class="active-pink-3 active-pink-4 mb-4">
            {{ csrf_field() }}
            <input class="form-control" type="text" placeholder="Nom" aria-label="Nom" name="lastname">
            <input class="form-control" type="text" placeholder="Prénom" aria-label="Prénom" name="firstname">
            <input type="submit" value="Search" name="submit" class="btn btn-right">
        </div>
    </form>
</div>