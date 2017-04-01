@extends('master')

@section('content')

<div class="products-main container">

    <div id="admin-updated" class="row">
        <div class="alert alert-success col-md-4 col-md-offset-4 updated" style="display: none;">
          <strong>OK!</strong> Produktas sėkmingai redaguotas.
        </div>

        <div class="alert alert-success col-md-4 col-md-offset-4 deleted" style="display: none;">
          <strong>OK!</strong> Produktas sėkmingai pašalintas.
        </div>
    </div>

    <div class="row">
        <a href="/admin/create"><button type="submit" class="btn btn-success">+ Sukurti Naują Produktą</button></a>
        <a href="/admin/reset-products"><button type="submit" class="btn btn-warning">Atstatyti produktų pavyzdžius</button></a>
    </div>


    <div class="all-products row">

        @foreach($products as $product)
        <div class="product col-xs-6 col-md-4">

            <div class="product-thumbnail">
                <div style="background-image: url('{{$product['image']}}');" class="product-image"></div>

                <div class="product-info">
                    <h6 style="font-weight:bold;" class="title">{{ $product['title'] }}</h6>
                </div>

                <div class="edit-buttons" id="{{$product['id']}}">
                    <button type="button" class="update btn btn-primary">Redaguoti</button>
                    <button type="button" class="delete btn btn-danger">Ištrinti</button>
                </div>
            </div>

        </div>
        @endforeach

    </div>

</div>



<style scoped>

.all-products {

}

.product {
    padding: 0;
}

.product-thumbnail {
    border: 1px solid grey;
    margin: 5px 5px;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.product-image {
    width: 90%;
    border-radius: 6px;
    height: 150px;
    margin-top: 10px;
    background-size: 60%;
    background-repeat: no-repeat;
    background-position: 50% 50%;
}

.product-info {
    height: 50px;
    margin: 1px;
    overflow: hidden;
    display: flex;
    align-items: center;
}

.edit-buttons {
    margin-bottom: 5px;
}


</style>

@endsection
