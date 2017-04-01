<div class="nav container">

    <div class="shop-logo">
        <a href="/"><img src="http://i.imgur.com/4J8c5tL.png" alt=""></a>
    </div>

    @if(Auth::check())
        <div class="if-admin">
            <p>Prisijungęs kaip administratorius</p>
            <a href="/admin">Tvarkyti produktus</a>
            |
            <a href="/logout">Atsijungti</a>
        </div>
    @endif

    <form class="search-area form-group has-feedback" action="/initsearch" method="post">
        {{ csrf_field() }}
        <input v-model="query" @keyup.13="query_go" name="query" type="text" class="form-control search-input" placeholder="Ieškoti"/>
        <i class="glyphicon glyphicon-search form-control-feedback"></i>
    </form>

</div>

<div class="nav-menu">
    <div class="dropdown">
      <h3><a href="/store">PRODUKTAI</a></h3>
      <div class="dropdown-content">
          @foreach($categories as $category)
                <a href="/store?category={{$category}}">{{$category}}</a>
          @endforeach
      </div>
    </div>

    <h3><a href="/contact">KONTAKTAI</a></h3>
    <h3><a href="/about">APIE</a></h3>
</div>


<div class="nav-vert-separator"></div>

<style scoped>
    .nav form {
        margin-left: auto;
    }

    .nav {
        margin-top: 15px;
        display: flex;
        align-items: center;
    }

    .shop-logo {
        margin: 0 auto;
        margin-left: 0px;
    }

    .shop-logo img {
        width: 75px;
    }

    .nav-vert-separator {
        height: 1px;
        width: 500px;
        background-color: lightgrey;
        margin: 25px auto;
    }

    .nav-menu {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        margin-top: 25px;
    }

    .nav-menu h3 a {
        color: black;
        font-weight: 600;
        transition: color 0.25s;
    }

    .nav-menu h3 a:hover{
        text-decoration: none;
        color: lightgrey;
    }

    .nav-menu h3 {
        font-size: 14px;
        margin: 0 20px;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 999;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {background-color: #f1f1f1}

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover h3 a{
        color: lightgrey;
    }

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    }
</style>
