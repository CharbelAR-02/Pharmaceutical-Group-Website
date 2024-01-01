@extends('layout')
@section('header')
    <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">
@endsection
@section('content')
    <div class="container first-div">

        <div class="col-lg-8 mb-5">
            <div class="title-heading">
                <h1 class="heading mb-3">The Best way to grow your pharmaceutical career</h1>
                <p class="para-desc text-50">Our Company will make sure that your medicines are
                    delivered on time and
                    be the best quality, your pharmacy's shelfs will never be empty</p>
            </div>
        </div>
        <div class="container">
            <div class="col-lg-6">
                <div class="faqs">
                    <div class="accordion" id="accordionExample2" role="tablist" aria-multiselectable="true">
                        <div class="card border-0 rounded-0">
                            <div class="card-header p-0" role="tab" id="History">
                                <h6 class="card-title position-relative mb-0">
                                    <a class="collapsed text-dark d-block" role="button" data-bs-toggle="collapse"
                                        href="#companyhistory" aria-expanded="false" aria-controls="companyhistory">Our
                                        History</a>
                                </h6>
                            </div>
                            <div id="companyhistory" class="collapse" role="tabpanel" aria-labelledby="History"
                                data-bs-parent="#accordionExample2">
                                <p class="mb-2 m-2">
                                    Our company has emerged as a prominent pharmaceutical distributor.
                                    Over the years, it has expanded its distribution network and adopted
                                    advanced
                                    technologies,
                                    ensuring efficient and timely medicine delivery across the nation.
                                </p>
                            </div>
                        </div>

                        <div class="card border-0 rounded-0 my-3">
                            <div class="card-header p-0" role="tab" id="GoalandVision">
                                <h6 class="card-title position-relative mb-0">
                                    <a class="collapsed text-dark d-block" role="button" data-bs-toggle="collapse"
                                        href="#Goal" aria-expanded="false" aria-controls="Goal"> Our Goal &
                                        Vision</a>
                                </h6>
                            </div>
                            <div id="Goal" class="collapse" role="tabpanel" aria-labelledby="GoalandVision"
                                data-bs-parent="#accordionExample2">
                                <p class="mb-2 mt-3 m-2">
                                    Our Goal is to have every customer pleased with our service, and for
                                    that, your
                                    customers should always be provided with
                                    the right medicine at the right time, to keep happiness blooming all
                                    over the
                                    times.
                                </p>
                            </div>
                        </div>

                        <div class="card border-0 rounded-0">
                            <div class="card-header p-0" role="tab" id="Profitability">
                                <h6 class="card-title position-relative mb-0">
                                    <a class="collapsed text-dark d-block" role="button" data-bs-toggle="collapse"
                                        href="#Profit" aria-expanded="false" aria-controls="Profit">
                                        Profitability</a>
                                </h6>
                            </div>
                            <div id="Profit" class="collapse" role="tabpanel" aria-labelledby="Profitability"
                                data-bs-parent="#accordionExample2">
                                <p class="mb-0 mt-3 m-2">
                                    Our Company has achieved consistent revenue growth and expanded its
                                    market
                                    presence.
                                    The company's commitment to competitive pricing and quality service
                                    has ensured
                                    a healthy profitability
                                    and have attracted investors.
                                </p>
                            </div>
                        </div><!--end card-->
                    </div><!--end accordion-->
                </div><!--end faqs-->
                <!-- End Accordion -->
            </div><!--end col-->
        </div><!--end row-->


    </div>
    <style>
        .first-div {
            margin-top: 120px;
        }
    </style>
@endsection
