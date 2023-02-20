@extends('layouts.user_type.auth')
@push('page-styles')
    <style>
        /*progressbar*/
        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            /*CSS counters to number the steps*/
            counter-reset: step;
            display: flex;
            justify-content: space-between;
        }

        #progressbar li {
            list-style-type: none;
            color: #666;
            text-transform: uppercase;
            font-size: 9px;
            text-align: center;
            position: relative;
            letter-spacing: 1px;
        }

        #progressbar li:before {
            content: counter(step);
            counter-increment: step;
            width: 24px;
            height: 24px;
            line-height: 26px;
            display: block;
            font-size: 12px;
            color: #333;
            background: white;
            border-radius: 25px;
            margin: 0 auto 10px auto;
        }

        /*progressbar connectors*/
        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: white;
            position: absolute;
            left: -50%;
            top: 9px;
            z-index: -1; /*put it behind the numbers*/
        }

        #progressbar li:first-child:after {
            /*connector not needed before the first step*/
            content: none;
        }

        /*marking active/completed steps blue*/
        /*The number of the step and the connector before it = blue*/
        #progressbar li.active:before, #progressbar li.active:after {
            background: #2098ce;
            color: white;
        }


    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul id="progressbar">
                <li @class([$tab == 'details' ? 'active':'' ])>Query Details</li>
                <li @class([$tab == 'doctor-review' ? 'active':'' ])>Doctors Remarks</li>
                <li @class([$tab == 'upload-medical-visa' ? 'active':'' ])>Uploaded Medical Visa</li>
                <li @class([$tab == 'payment-required' ? 'active':'' ])>Payment</li>
                <li @class([$tab == 'upload-ticket' ? 'active':'' ])>Uploaded Tickets & Visa</li>
                <li @class([$tab == 'coordinator' ? 'active':'' ])>Assign Coordinator, Hotel and Cab</li>
            </ul>
        </div>
    </div>
    @switch($tab)

        @case($tab == 'details')
            @include('module.queries.details')
            @break

        @case($tab == 'doctor-review')
            @include('module.queries.doctor-review')
            @break

        @case($tab == 'upload-medical-visa')
            @include('module.queries.upload-medical-visa')
            @break

        @case($tab == 'payment-required')
            @include('module.queries.payment')
            @break

        @case($tab == 'upload-ticket')
            @include('module.queries.upload-tickets')
            @break

        @case($tab == 'coordinator')
            @include('module.queries.coordinator')
            @break
        @default
            @include('module.queries.details')
    @endswitch


@endsection

@push('scripts')
    <script>

    </script>
@endpush