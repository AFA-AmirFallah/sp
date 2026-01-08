<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd"
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">


    @if ($type == 'main')
        @if ($LastPost != null)
            <url>
                <loc>
                    {{ str_replace('http://', 'https://', route('post_sitemap')) }}
                </loc>

                <lastmod>{{ Carbon\Carbon::parse($LastPost)->format('Y-m-d\TH:i:s+03:30') }}</lastmod>
            </url>
        @endif
        @if ($LastPage != null)
            <url>
                <loc>
                    {{ str_replace('http://', 'https://', route('page_sitemap')) }}
                </loc>

                <lastmod>{{ Carbon\Carbon::parse($LastPage)->format('Y-m-d\TH:i:s+03:30') }}</lastmod>
            </url>
        @endif
        @if ($LastPorduct != null)
            <url>
                <loc>
                    {{ str_replace('http://', 'https://', route('product_sitemap')) }}
                </loc>

                <lastmod>{{ Carbon\Carbon::parse($LastPorduct)->format('Y-m-d\TH:i:s+03:30') }}</lastmod>
            </url>
        @endif
    @elseif($type == 'post')
        @foreach ($Posts as $Post)
            <url>
                <loc>
                    @if ($Post->OutLink == null)
                        {{ str_replace('http://', 'https://', route('ShowNewsItem', ['NewsId' => $Post->id, 'newsitem' => $Post->Titel])) }}
                    @else
                        {{ str_replace('http://', 'https://', route('ShowNewsItem', ['NewsId' => $Post->OutLink])) }}
                    @endif
                </loc>
                <image:image>
                    <image:loc>{{ str_replace('http://', 'https://', $Post->MainPic) }}</image:loc>
                </image:image>
                <lastmod>{{ Carbon\Carbon::parse($Post->updated_at)->format('Y-m-d\TH:i:s+03:30') }}</lastmod>
            </url>
        @endforeach
    @elseif($type == 'cover')
        @foreach ($Posts as $Post)
            <url>
                <loc>
                    {{ str_replace('http://', 'https://', route('newscat', ['newscat' => $Post->newscat])) }}
                </loc>
                <image:image>
                    <image:loc>{{ str_replace('http://', 'https://', $Post->MainPic) }}</image:loc>
                </image:image>
                <lastmod>{{ Carbon\Carbon::parse($Post->updated_at)->format('Y-m-d\TH:i:s+03:30') }}</lastmod>
            </url>
        @endforeach
    @elseif($type == 'page')

    @elseif($type == 'product')
        @foreach ($ProductSrc as $Product)
            <url>
                @if ($Product->urladdress == null)
                    <loc>
                        {{ str_replace('http://', 'https://', route('SingleProduct', ['productID' => $PreTag . $Product->id, 'productName' => $Product->NameFa])) }}
                    </loc>
                @else
                    <loc>{{ str_replace('http://', 'https://', url('/')) }}/product/{{ $Product->urladdress }}</loc>
                @endif
                <lastmod>{{ Carbon\Carbon::parse($Product->updated_at)->format('Y-m-d\TH:i:s+03:30') }}</lastmod>
            </url>
        @endforeach
    @elseif($type == 'deal')
        @foreach ($deal_src as $deal_item)
            <url>
                <loc>
                    {{ str_replace('http://', 'https://', route('files', ['file_id' => $deal_item->id])) }}
                </loc>

                <lastmod>{{ Carbon\Carbon::parse($deal_item->updated_at)->format('Y-m-d\TH:i:s+03:30') }}</lastmod>
            </url>
        @endforeach
    @endif
</urlset>
