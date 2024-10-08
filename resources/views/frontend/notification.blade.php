@extends('frontend.layouts.app')
@section('title', 'Notification')
@section('content')
<div>
    <div class="infinite-scroll">
        @foreach ($notifications as $notification)
        <a href="{{url('notification/' . $notification->id)}}">
            <div class="card mb-2">
                <div class="card-body p-2">
                    <h6><img src="{{asset('img/alarm.gif')}}" class="@if(is_null($notification->read_at)) text-danger @endif" alt="" style="width: 25px; height:25px;"> {{Illuminate\Support\Str::limit($notification->data['title'], 40)}}</h6>
                    <p class="mb-1">{{Illuminate\Support\Str::limit($notification->data['message'], 100)}}</p>
                    <small class="text-muted mb-1">{{Carbon\Carbon::parse($notification->created_at)->format('Y-m-d h:i:s A')}}</small>
                </div>
            </div>
        </a>
        @endforeach
        {{$notifications->links()}}
    </div>
</div>
@endsection
@section('scripts')
<script>
    $('ul.pagination').hide();
    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            loadingHtml: '<div class="text-center"><img src="/images/loading.gif" alt="Loading..." /></div>',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    });
</script>
@endsection
