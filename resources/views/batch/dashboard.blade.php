@extends('layout.app')
@section('content')

    <!--begin::Row-->
    <div class="row gy-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-xl-4">
            <!--begin::Mixed Widget 2-->
            <div class="card card-xl-stretch">
                <!--begin::Header-->
                <div class="card-header border-0 bg-danger py-5">
                    <h6 class="card-title fw-bolder text-white" style="font-size: 4rem;">Entity Locker</h6>
                    <div class="card-toolbar">

                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body p-0" >
                    <!--begin::Chart-->
                <!--	<div class="mixed-widget-2-chart card-rounded-bottom bg-danger" data-kt-color="danger" style="height: 200px"></div> -->
                <div class="card-rounded-bottom bg-danger" data-kt-color="danger" style="height: 130px"></div>
                    <!--end::Chart-->

                    <!--begin::Stats-->
                    <div class="card-p mt-n20 position-relative">

                        <!--begin::Row-->
                        <div class="row g-0">


                            <!--begin::Col-->
                            <div class="col bg-light-primary px-6 py-8 rounded-2 me-7 mb-7">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="currentColor" />
                                        <path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <a href="{{ route('total_listing') }}" class="text-primary fw-bold fs-6">Total Request</a>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col bg-light-success px-6 py-8 rounded-2 mb-7">
                                <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                                <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M6 8.725C6 8.125 6.4 7.725 7 7.725H14L18 11.725V12.925L22 9.725L12.6 2.225C12.2 1.925 11.7 1.925 11.4 2.225L2 9.725L6 12.925V8.725Z" fill="currentColor" />
                                        <path opacity="0.3" d="M22 9.72498V20.725C22 21.325 21.6 21.725 21 21.725H3C2.4 21.725 2 21.325 2 20.725V9.72498L11.4 17.225C11.8 17.525 12.3 17.525 12.6 17.225L22 9.72498ZM15 11.725H18L14 7.72498V10.725C14 11.325 14.4 11.725 15 11.725Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <a href="{{ route('success_listing') }}" class="text-success fw-bold fs-6">Success Request</a>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row g-0">
                            <!--begin::Col-->
                            <div class="col bg-light-danger px-6 py-8 rounded-2 me-7">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor" />
                                        <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <a href="{{ route('failed_listing') }}" class="text-danger fw-bold fs-6 mt-2">Failed Request</a>
                            </div>
                            <!--end::Col-->


                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Mixed Widget 2-->
        </div>
        <!--end::Col-->


        <!--begin::Col-->
        <div class="col-xl-4">

            <!--begin::Mixed Widget 7-->
            <div class="card card-xl-stretch-50 mb-5 mb-xl-8">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column p-0">
                    <!--begin::Stats-->
                    <div class="flex-grow-1 card-p pb-0">
                        <div class="d-flex flex-stack flex-wrap">
                            <div class="me-2">
                                <span><a href="{{ route('total_listing') }}" class="text-dark text-hover-primary fw-bolder" style="font-size: 2rem;">Total Request</a></span><br>
                            </div>

                        </div><br>
                        <div class="fw-bolder fs-3 text-primary" style="font-size: 3rem !important;">{{$count['totalCount']}}</div>
                    </div>
                    <!--end::Stats-->
                    <!--begin::Chart-->
            <!--		<div class="mixed-widget-7-chart card-rounded-bottom" data-kt-chart-color="primary" style="height: 150px"></div>   -->
                    <!--end::Chart-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Mixed Widget 7-->


             <!--begin::Mixed Widget 7-->
             <div class="card card-xl-stretch-50 mb-5 mb-xl-8">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column p-0">
                    <!--begin::Stats-->
                    <div class="flex-grow-1 card-p pb-0">
                        <div class="d-flex flex-stack flex-wrap">
                            <div class="me-2">
                                <span><a href="{{ route('failed_listing') }}" class="text-dark text-hover-primary fw-bolder" style="font-size: 2rem;">Failed Request</a></span><br>
                            </div>

                        </div><br>
                        <div class="fw-bolder fs-3 text-primary" style="font-size: 3rem !important;">{{$count['failCount']}}</div>
                    </div>
                    <!--end::Stats-->
                    <!--begin::Chart-->
            <!--		<div class="mixed-widget-7-chart card-rounded-bottom" data-kt-chart-color="primary" style="height: 150px"></div>   -->
                    <!--end::Chart-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Mixed Widget 7-->



        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-xl-4">

            <!--begin::Mixed Widget 7-->
            <div class="card card-xl-stretch-50 mb-5 mb-xl-8">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column p-0">
                    <!--begin::Stats-->
                    <div class="flex-grow-1 card-p pb-0">
                        <div class="d-flex flex-stack flex-wrap">
                            <div class="me-2">
                                <span><a href="{{ route('success_listing') }}" class="text-dark text-hover-primary fw-bolder" style="font-size: 2rem;">Success Request</a></span><br>
                            </div>

                        </div><br>
                        <div class="fw-bolder fs-3 text-primary" style="font-size: 3rem !important;">{{$count['successCount']}}</div>
                    </div>
                    <!--end::Stats-->
                    <!--begin::Chart-->
            <!--		<div class="mixed-widget-7-chart card-rounded-bottom" data-kt-chart-color="primary" style="height: 150px"></div>   -->
                    <!--end::Chart-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Mixed Widget 7-->
        </div>
        <!--end::Col-->

    </div>
    <!--end::Row-->


@endsection
