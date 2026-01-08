<div class="checkout">
    <div class="" id="FinalizeOrder">
        <div class="page-content">
            <div style="padding: 10px" class="container">
                    <div >
                        <div class="col-lg-7 pr-lg-4 mb-4" style="border: 1px solid var(--color_palet_6);
                        border-radius: 4px;">
                            <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
                            </h3>
                            <div class="form-group checkbox-toggle pb-2">
                                <input id="addnewaddressRadio" onchange="newaddress()" type="radio"
                                    class="custom-checkbox"  name="Location" value="0">
                                <label for="shipping-toggle">افزودن آدرس جدید    </label>
                            </div>
                            <div id="addnewaddress" class="checkbox-content">
                                <div class="row gutter-sm">
                                    @include('Layouts.Theme1.objects.AddressAddFilds')
                                </div>
                            </div>

                            <div id="ShowRegistedAddress">

                                <div class="form-group mt-3">

                                    <div class="col-sm-6 mb-6">
                                        <div class="ecommerce-address billing-address pr-lg-8">

                                            <h4 class="title title-underline ls-25 font-weight-bold">آدرس ها </h4>
                                            @foreach ($Order->get_User_Locations() as $Locations)
                                                <address class="mb-4">

                                                    <table class="address-table">

                                                        <tbody>

                                                            <tr>
                                                                <input type="radio"
                                                                    class="custom-checkbox" value="{{ $Locations->id }}" id="radio_{{ $Locations->id }}"
                                                                    name="Location">

                                                                <label >انتخاب آدرس </label>
                                                            </tr>



                                                            <tr>
                                                                <th>نام :</th>
                                                                <td>
                                                                    {{ $Locations->recivername }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>استان:</th>
                                                                <td>
                                                                    {{ $Locations->Province }}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th>شهر :</th>
                                                                <td>
                                                                    {{ $Locations->City }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>آدرس:</th>
                                                                <td>
                                                                    {{ $Locations->Street }} -
                                                                    {{ $Locations->OthersAddress }}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th>تلفن:</th>
                                                                <td> {{ $Locations->recivername }} </td>
                                                            </tr>

                                                        </tbody>

                                                    </table>
                                                </address>
                                                <div class="accordion payment-accordion">
                                                    <div class="card">
                                                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                                            <a   href="#Address"
                                                                onclick="editaddress({{ $Locations->id }})"
                                                                class="expand">آدرس
                                                                صورتحساب خود را ویرایش کنید</a>
                                                        </div>
                                                        <div id="Address" class="card-body collapsed">
                                                            <div id="editAddress{{ $Locations->id }}"> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input class="nested" type="text" id="LocationCity_{{ $Locations->id }}"
                                                value="{{ $Locations->CityID }}">
                                                <input class="nested" type="text" id="LocationProvince_{{ $Locations->id }}"
                                                value="{{ $Locations->ProvinceID }}">

                                            @endforeach



                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                        </div>

