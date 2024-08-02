<style>
.explore-item.cat{{$cat->id}} .explore-thumb:before{
    background-color:{{$cat['color_code']?$cat['color_code']:'rgb(240 223 98 / 70%)'}};
    opacity: 0.7;
}
</style>