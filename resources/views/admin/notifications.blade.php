@extends('admin.master')

@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">ALL Notifications</h1>

  <div class="list-group">
    @foreach (Auth::user()->notifications as $item)
    <a href="{{ $item->data['url']}}" class="list-group-item list-group-item-action {{$item->read_at ? '' : 'bg-light'}} " aria-current="true">
{{ $item->data['msg']}}
    </a>
    @endforeach

  </div>

@endsection
@section('title','Dashbard')
