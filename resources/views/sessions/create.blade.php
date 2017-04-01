@extends('master')

@section('content')

<div class="login-form">

    <h1>Prisijunkite</h1>

    <form action="/login" method="post">

        {{ csrf_field() }}

        <div class="form-group">
            <label for="exampleInputEmail1">Email:</label>
            <input value="admin@admin.com" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password:</label>
            <input value="admin" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
        </div>

        <button type="submit" class="btn btn-default">Prisijungti</button>

    </form>

    @if(count($errors))
        <div class="errors">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

</div>

<style scoped>
    .login-form {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-top: 50px;
    }
</style>

@endsection
