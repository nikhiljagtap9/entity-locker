@extends('layout.app')
@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="row gy-5">
                <div class="col-xl-12">
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!-- Begin::Body for Image and Sessions -->
                        <div class="card-body d-flex flex-column p-0" style="height: 100%;">

                            <!-- Upper part: Image -->
                            <div style="height: 50vh; overflow: hidden;" class="rounded">
                                <img src="assets/media/logos/Group.png" alt="Image"
                                    style="height: 100%; width: 100%; object-fit: cover;">
                                <!-- The image will fill the upper half of the container and scale properly -->
                            </div>

                        </div>
                        <!-- End::Body for Image and Sessions -->
                    </div>
                 </div> 

                <div class="col-xl-8">
                    <div class="card mb-5 mb-xl-8">
                        <!-- Begin::Body for Image and Sessions -->
                        <div class="card-body d-flex flex-column p-0" style="height: 100%;">

                            <!-- Upper part: Image -->
                            <div style="overflow: hidden;"></div>

                            <!-- Lower part: Sessions (In a single line, one after another) -->
                            <div class="d-flex justify-content-between p-3" style="height: 50%;">
                                <!-- Flex for horizontal alignment -->   
                                 <!-- Total Request Card -->
                                <div class="d-flex align-items-center bg-light-primary rounded p-5 mb-7 mx-2">
                                    <!--begin::Icon-->
                                    <span class="svg-icon svg-icon-primary me-5">
                                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor"></path>
                                                <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <div class="flex-grow-1 me-2">
                                        <a href="{{ route('total_listing') }}" class="fw-bolder text-gray-800 text-hover-primary fs-6">Total Request</a>
                                       <!-- <span class="text-muted fw-bold d-block">Due in 2 Days</span> -->
                                    </div>
                                    <!--end::Title-->
                                    <!--begin::Lable-->
                                    <span class="fw-bolder text-warning py-1">{{$count['totalCount']}}</span>
													<!--end::Lable-->
								</div>

                                <!-- Approved Request -->
                                <div class="d-flex align-items-center bg-light-success rounded p-5 mb-7 mx-2">
                                    <!--begin::Icon-->
                                    <span class="svg-icon svg-icon-success me-5">
                                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor"></path>
                                                <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <div class="flex-grow-1 me-2">
                                        <a href="{{ route('success_listing') }}" class="fw-bolder text-gray-800 text-hover-primary fs-6">Success Request</a>
                                        <!-- <span class="text-muted fw-bold d-block">Due in 2 Days</span> -->
                                    </div>
                                    <!--end::Title-->
                                    <!--begin::Lable-->
                                    <span class="fw-bolder text-warning py-1">{{$count['successCount']}}</span>
													<!--end::Lable-->
								</div>

                                <!-- Failed Request Card -->
                                <div class="d-flex align-items-center bg-light-danger rounded p-5 mb-7 mx-2">
                                    <!--begin::Icon-->
                                    <span class="svg-icon svg-icon-danger me-5">
                                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor"></path>
                                                <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <!--end::Icon-->
                                    <!--begin::Title-->
                                    <div class="flex-grow-1 me-2">
                                        <a href="{{ route('failed_listing') }}" class="fw-bolder text-gray-800 text-hover-primary fs-6">Failed Request</a>
                                        <!-- <span class="text-muted fw-bold d-block">Due in 2 Days</span> -->
                                    </div>
                                    <!--end::Title-->
                                    <!--begin::Lable-->
                                    <span class="fw-bolder text-warning py-1">{{$count['failCount']}}</span>
													<!--end::Lable-->
								</div>
                            </div>
                        </div>
                        <!-- End::Body for Image and Sessions -->
                    </div>
                </div>

                <div class="col-xl-4">
                    <div style="height: 50vh; overflow: hidden;">
                        <img src="assets/media/logos/Group_1.png" alt="Image"
                            style="height: 100%; width: 100%; object-fit: cover;">
                        <!-- The image will fill the upper half of the container and scale properly -->
                    </div>
                </div>

                <!-- End::Col for the new Section -->


                <!--end::Stats-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Mixed Widget 7: Failed Request-->
    </div>
    <!--end::Col-->




    </div>
    <!--end::Row-->
@endsection