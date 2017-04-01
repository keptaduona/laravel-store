@extends('master')

@section('content')

    <div class="col-md-6 col-md-offset-3" style="text-align: center">
        <span style="font-size: 30px;" class="glyphicon glyphicon-ok-sign"></span>
        <p>Puslapyje naudota: </p>
        <ul style="list-style: none; padding: 0">
            <li>Laravel</li>
            <li>Vue.js & Laravel Mix</li>
            <li>jQuery & Axios</li>
            <li>Bootstrap 3</li>
        </ul>

        <h1 style="color: green; margin-top: 50px;">ADMIN => <a href="/admin"><button type="button" class="btn btn-success">Click Me</button></a></h1>
    </div>

@endsection
