@extends('admin.layouts.app')
@section('main')
    @include('admin.layouts.top-nav')
    <div class="container py-12">
            <div class="col-md-12">
                <label for="inputCity" class="form-label">Vote Count: </label><b><span>{{$id['votes_count']}}</span></b>
              </div>
              <div class="col-md-12">
                <label for="inputCity" class="form-label">Category : </label><b><span>{{$id['category']['name']}}</span></b>

            </div>
            <div class="col-md-12">
                <label for="inputCity" class="form-label">Title : </label><b><span>{{$id['title']}}</span></b>
              </div>
            <div class="col-md-12">
                <label for="inputCity" class="form-label">Description : </label><b><span>{{$id['description']}}</span></b>
              </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="formFile" class="form-label">File : </label>
                    <img style="    width: 50%;" src="{{asset('FeedbackImages/'.$id['attachments'].'')}}">
                </div>
                <div class="col-md-6 mt-1">
                    <h6>FeedBack Item Comments</h6>
                    <div class="post-comments-{{ $id['id'] }}">
                        @if (count($id['comments']))

                            @foreach ($id['comments'] as $key2 => $data)
                                <div class="mt-4 d-flex">
                                    <div class="ms-3 mt-2">
                                        <h6 class="fs-13 mb-0 fw-bold">
                                            {{ $data['user']['name']}} ( {{ date_format($data['created_at'], 'd-M-Y ') }} )
                                        </h5>
                                        {{ $data->content }}
                                    </div>
                                    <div> <button type="button" url="{{route("admin.feedback.comment.delete", ['id' => $data['id']])}}" class="btn btn-danger btn-sm delete-comment m-2">Delete</button></div>
                                </div>
                            @endforeach
                        @else
                        @endif

                    </div>


                    <!-- Add Commennt Box -->
                    {{-- <form class="comment-form">
                        <div class="comment-box mt-4 d-flex">
                            <div class="w-100">
                                <input type="text" name="comentData"
                                    class="comentData-{{ $id->id }} w-100 px-4" id=""
                                    placeholder="Write Here....">
                            </div>
                            <div>
                                <input type="hidden" id="postid"
                                    name="postid-{{ $id->id }}" value="{{ $id->id }}">
                                    <button type="button" url="{{route('feedback.comment')}}" class="comment-button btn p-0 scale-img"
                                    data-get-id="{{ $id->id }}"><img style="width: 40px"
                                        src="{{ asset('img/comment-btn.svg') }}"
                                        alt=""></button>
                            </div>
                        </div>
                    </form> --}}

                </div>


            </div>
    </div>
 @endsection


