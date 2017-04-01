<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="/css/jquery-ui.css">
    <link type="text/css" rel="stylesheet" href="/lightSlider/css/lightslider.css" />
    <style>
        .container {
            max-width: 980px;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            overflow: auto;
            height:100%;
        }
    </style>



</head>

<body>

<div>

    @include('layouts.nav')

    @yield('content')

    @include('layouts.footer')

</div>
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
<script src="/js/app.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.min.js"></script>




</body>


</html>
