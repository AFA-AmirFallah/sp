<section id="least_blog" class="container  py-3 py-sm-3 ">
    <h5 class="IRANSansWeb_Medium bt-color text-center">  {{ $mobile_banner->title }} </h5>
    <div class="row value-body mt-4 mx-1">
       
        @foreach (App\Functions\NewsClass::NewsListByIndexID(App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'TagUID'), App\Functions\Themes::get_value_from_Json($mobile_banner->pic, 'Limit')) as $PostItem)
        <div id="s_post" class="col-lg-5 py-3 pl-3">
            <div class="d-flex flex-column">
                <div class="d-flex flex-md-row flex-column mb-2">
                    <img src="{{ $PostItem->MainPic }}" class="img-fluid ml-3 rad10 mb-2" />
                    <div>
                        <a href="{{ route('ShowNewsItem', [$PostItem->id]) }}"class="IRANSansWeb_Medium"> {{ $PostItem->Titel }}</a>
                        <p>{{ $PostItem->SubTitel }} </p>
                        
                     
                    </div>
                </div>
             
            </div>

            
        </div>
        @endforeach
        
      


    </div>
</section>