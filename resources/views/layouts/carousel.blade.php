<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="http://arch5.com/wp-content/uploads/2014/12/bedroom-cal-king-mattress-size-modern-contemporary-beds-and-beds-bedroom-sets-pagefurniture-design-beds-queen-kathy-ireland-furniture-quality-bedroom-furniture-bed-furniture-sets-designing-with-brow.jpg">
            <div class="carousel-caption">
            </div>
        </div>
        <div class="item">
            <img src="https://s-media-cache-ak0.pinimg.com/originals/b3/d3/19/b3d319c134236c60b22dd526a3b3798a.jpg">
            <div class="carousel-caption">
            </div>
        </div>
        <div class="item">
            <img src="http://cdn.home-designing.com/wp-content/uploads/2013/01/elegant-modern-living-room.jpg">
            <div class="carousel-caption">
            </div>
        </div>

    </div>



</div>

<div style="margin-top: 50px;" class="nav-vert-separator"></div>

<!-- $product variable comes from App\Providers\ComposerServiceProvider.php -->
<div class="item container" style="margin-bottom: 50px; height: 400px">
    <h3 style="text-align: center; margin-top: 25px;">Naujausi Produktai</h3>
    <ul id="content-slider" class="content-slider">
        @foreach($products as $product)
        <li id="{{$product['id']}}">
            <img src="{{$product['image']}}" alt="">
        </li>
        @endforeach
    </ul>
</div>



<style scoped>
    /* -- CAROUSEL -- */
    .carousel {
        max-width: 975px;
        height: 500px;
        margin: 0 auto;
    }

    .carousel-inner > .item > a > img,
    .carousel-inner > .item > img {
        width: 100%;
        height: 500px;
    }

    @media screen and (max-width: 720px) {
        .carousel {
            height: 300px;
        }
        .carousel-inner > .item > a > img,
        .carousel-inner > .item > img {
            height: 300px;
        }
    }


    #content-slider li{
        text-align: center;
        color: #FFF;
    }
    #content-slider li img{
        max-width: 100%;
    }
</style>
